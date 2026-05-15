<?php

namespace App\Http\Controllers\Vendor\Traits;

use App\Actions\Order\MakeOrder;
use App\Models\Blacklist;
use App\Models\Country\Country;
use App\Models\Delegation;
use App\Models\Facility\Facility;
use App\Models\ListsOfSuspects\ListsOfSuspect;
use App\Models\Setting;
use App\Models\SuspectsRegistrationRequests;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\Vendor;
use App\Services\Integration\DowJonse;
use App\Services\Integration\Nafaz;
use App\Services\Integration\Wathiq;
use App\Services\Integration\Yakeen;
use App\Traits\ApiResponseTrait;
use GeniusTS\HijriDate\Hijri;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

trait HandleVendorRegister
{
    use ApiResponseTrait;

    private $keys = ['first_name', 'second_name', 'third_name', 'fourth_name'];
    private $yaqeen_name;
    private $is_suspected = false;

    protected function getVendorStep($request, $vendor)
    {
        $facility = $vendor->facilities()->first();
        $data = [
            'identity_number' => $vendor->user->identity_number,
            'user_id' => $vendor->user_id,
            'step' => $vendor->refresh()->step,
            'account_type' => $facility?->account_type,
            'is_delegator' => $vendor->is_delegator,
        ];
        return $this->successResponse(data: $data, message: __('auth.please_complete_your_register_data'));
    }

    private function checkIfVendorSuspect($user, $facility)
    {
        $identities = [];
        $parties = @$facility?->wathiq_data['parties'];
        if ($parties) {
            $identities = collect($parties)->pluck('identity.id')->toArray();
        }
        $identities[] = $user->identity_number;

        $vendor_exists_in_suspects = ListsOfSuspect::whereIn('global_id_number', array_unique($identities))
            ->whereHas('blacklist', function ($q) {
                $q->where('status', Blacklist::ENTERED);
            })->first();
        $suspectRequest = '';
        if (($user->vendor->is_delegator == 0 && $user->vendor->type == Vendor::COMMERCIAL_RECORD) || $user->vendor->is_delegator == 0) {
            $suspectRequest = SuspectsRegistrationRequests::checkIfUserInSuspectList($facility, $user, $vendor_exists_in_suspects);
        }
        $code = $suspectRequest->code ?? generate_unique_code(Delegation::class, 'delegation_code', 6, 'lower');
        $number = $suspectRequest->number ?? generate_unique_code(Delegation::class, 'delegation_number', 6, 'numbers');
        //store User order action
        if (!($suspectRequest instanceof UserOrder) && $user->vendor->is_delegator == 0) {
            app()->call(new MakeOrder($user->id, $user->vendor, $code, $number, $facility->record_number));
        }
        return $suspectRequest;
    }

    public function blackListResponse($user, $facility, $suspectRequest = null, $message = null)
    {
        //        $status = ($user->ban_status == 'not_verified_banned' ||
        //            ($user->ban_status == 'waiting_otp' && $user->vendor?->step == 4 && $user->latest_order?->status == UserOrder::ACCEPTED))
        //            ? $user->ban_status : ($user?->latest_order->status ?? User::PENDING);
        $status = User::PENDING;
        $vendor = $user->vendor;

        return $this->successResponse(data: [
            'identity_number' => $user->identity_number,
            'phone' => '9665*****' . substr($user->phone, -1, 3),
            'user_id' => $user->id,
            'step' => $vendor->refresh()->step,
            'code' => $user->latest_order?->code ?? null,
            'number' => $user->latest_order?->number ?? null,
            'status' => $status,
            'status_trans' => __('dashboard.user_orders.status.' . $status),
            'account_type' => $facility?->account_type,
            'is_delegator' => (bool)$vendor->is_delegator,
            'company_capital' => $user?->facility?->company_capital,
            'in_black_list' => (bool)($suspectRequest ?? SuspectsRegistrationRequests::inBlackList($user)),
        ], message: $message ?? '');
    }

    protected function getUserDataFromRequestAndYaqeen($request)
    {
        $yaqeen = Yakeen::create(['iqama_number' => $request->identity_number, 'date_of_birth' => $request->date_of_birth, 'token' => "We Will Do It Later"])->send();
        if ((isset($yaqeen['status']) && !$yaqeen['status']) || !$yaqeen) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'data' => null,
                'message' => @$yaqeen['message'] ?? __('dashboard.auth.validation.data_doesnt_correct')
            ], 422));
        }
        $user_data = $request->only('identity_number', 'phone', 'email', 'country_code', 'date_of_birth', 'nationality_id', 'name');
        $user_data += [
            'first_name' => @$yaqeen['data']['firstName'],
            'second_name' => @$yaqeen['data']['fatherName'] ?? @$yaqeen['data']['secondName'],
            'third_name' => @$yaqeen['data']['grandFatherName'] ?? @$yaqeen['data']['thirdName'],
            'fourth_name' => @$yaqeen['data']['familyName'] ?? @$yaqeen['data']['lastName'],
            'date_of_birth_hijri' => @$yaqeen['data']['dateOfBirthH'],
            'character_type' => ($request->type != Facility::COMMERCIAL_RECORD ? 'natural' : 'company'),
            'password' => User::randomPassword(),
            'ban_status' => 'waiting_otp',
            'ban_reason' => 'dashboard.auth.waiting_otp',
            'verified_code' => User::getVerifiedUniqueCode(),
            'user_type' => 'vendor',
            'account_status' => User::PENDING,
            'is_deleted' => false,
            'gender' => @$yaqeen['data']['gender'] == 'F' ? 'female' : 'male'
        ];
        $this->yaqeen_name = array_only($user_data, $this->keys);
        $this->handleUserSuspect([
            'fullname' => join(' ', $this->yaqeen_name),
            'identity' => ['id' => $user_data['identity_number']],
        ], true);
        return $user_data;
    }

    protected function checkIfSuspectedUsers($users, $owner)
    {
        foreach ($users as $user) {
            $user['fullname'] = $user['name'];
            if ($this->handleUserSuspect($user)) {
                $this->createSuspect($owner);
                break;
            }
        }
    }

    private function handleUserSuspect($user, $is_owner = false)
    {
      //  Send To DwoJonse
//        $suspect = DowJonse::create()->setToken(get_dwo_jonse_token())->setBody([
//            'ar_name' => $user['fullname'],
//            'en_f_name' => '',
//            'en_l_name' => '',
//            'any_id' => '',
//            'limit_by' => 1
//        ])->send();
//
//        $list_suspects = ListsOfSuspect::whereHas('blacklist', function ($q) {
//            $q->where('status', Blacklist::ENTERED);
//        })->pluck('global_id_number')->toArray();
//
//        if ($suspect && $is_owner) {
//            $this->createSuspect($user);
//            return false;
//        } elseif (in_array(@$user['identity']['id'], $list_suspects)) {
//            return true;
//        }
        return false;
    }

    private function createSuspect($user)
    {
        $this->is_suspected = true;
    }

    protected function getFacilityDataFromRequestAndWathiq($request, $facility_code)
    {
        $facility_data = $request->validated();
        $facility_data = array_merge($facility_data, [
            'facility_code' => $facility_code,
            'nationality_id' => !in_array(Vendor::COMMERCIAL_RECORD, [$request->type, $request->account_type]) ? Country::where('phone_code', 966)->value('id') : $request->facility_nationality_id,
            'account_type' => !in_array(Vendor::COMMERCIAL_RECORD, [$request->type, $request->account_type]) ? Facility::DOCUMENT : Facility::COMMERCIAL_RECORD,
            'document_type' => !in_array(Vendor::COMMERCIAL_RECORD, [$request->type, $request->account_type]) ? Vendor::FREE_WORK_DOCUMENT : null,
            'account_status' => Facility::NOT_COMPLETED,
        ]);
        if (in_array(Facility::COMMERCIAL_RECORD, [$request->type, $request->account_type])) {
            $wathiq = Wathiq::create(['commercial_id' => $request->record_number, 'token' => "We Will Do It Later"])->send();
            if ((isset($wathiq['status']) && !$wathiq['status']) || !$wathiq) {
                throw new HttpResponseException(response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => @$wathiq['message'] ?? __('dashboard.auth.validation.data_doesnt_correct')
                ], 422));
            }
            $filtered = array_where($wathiq['data']['parties'], function ($item) use ($request) {
                return $request->identity_number == @$item['identity']['id'] && in_array(@$item['relation']['id'], Facility::MANAGERS);
            });

            $this->checkIfSuspectedUsers($wathiq['data']['parties'], [
                'fullname' => $request->name,
                'identity' => ['id' => $request->identity_number]
            ]);
            $facility_data += [
                'status' => @$wathiq['data']['status']['id'] == 'canceled' ? 'in_active' : 'hold',
                'creation_date' => convert_to_gregorian(@$wathiq['data']['company']['startDate']),
                'start_at' => convert_to_gregorian(@$wathiq['data']['issueDate']),
                'end_at' => convert_to_gregorian(@$wathiq['data']['expiryDate']),
                'company_capital' => @$wathiq['data']['capital']['paidAmount'],
                'wathiq_data' => @$wathiq['data'],
                'is_delegator' => count($filtered) == 0,
                'is_suspected' => $this->is_suspected,
                'ar' => [
                    'name' => @$wathiq['data']['crName'] ?? (@$request->ar['name'] ?? 'facility_' . $facility_code)
                ],
            ];
        } else {
            $facility_data += [
                'is_delegator' => false,
                'ar' => [
                    'name' => (@$request->ar['name'] ?? 'facility_' . $facility_code)
                ],
            ];
        }
        return $facility_data;
    }

    private function checkIfIdentityHasPhone($request)
    {
        //TODO:: Send to Nafaz to check if user has this phone number
        $nafez = Nafaz::create(['iqama_number' => $request->identity_number, 'phone' => ($request->country_code ?? 966) . $request->phone, 'token' => 'WE Will ADD it Later'])->send();
        if ((isset($nafez['status']) && !$nafez['status']) || !$nafez) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'data' => null,
                'message' => @$nafez['message'] ?? __('dashboard.auth.validation.data_doesnt_correct')
            ], 422));
        } elseif (isset($nafez['status']) && !$nafez['data']['isOwner']) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'data' => null,
                'message' => __('dashboard.auth.validation.identity_number_doesnt_have_phone')
            ], 422));
        }
    }
}
