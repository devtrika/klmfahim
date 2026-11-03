<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    //

    public function getLogin() {
        if (Auth::Check()) {
            return redirect('trika');
        }
        return view('admin.home.login');
    }

    public function postLogin() {
        $inputs = Request()->all();

        $remember = FALSE;
        if (isset($inputs['remember'])) {
            $remember = TRUE;
        }
        if (Auth::attempt(['username' => $inputs['username'], 'password' => $inputs['password']], $remember)) {
            $active = Auth::user()->active;
            $type = Auth::user()->type;

            if ($active == 'yes' && $type == "admin") {
                return redirect()->intended('trika');
            } else {
                Auth::logout();
                return back()->withInput()->withError(trans('layout.not_allow'));
            }
        } else {
            return back()->withInput()->withError(trans('layout.wrong_login'));
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('trika/login');
    }

    public function index() {
        if (!Auth::Check()) {
            return redirect('trika/login');
        }

        return view('admin.home.index', $this->dashboard());
    }

    /** Numbers for the dashboard; each block only when the admin may see that module. */
    private function dashboard(): array {
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $lastMonthStart = $monthStart->copy()->subMonth();
        $data = [];

        if (can_do('requests')) {
            $requests = \App\Models\CostRequest::query();
            $daily = \App\Models\CostRequest::where('created_at', '>=', $now->copy()->subDays(29)->startOfDay())
                ->selectRaw('DATE(created_at) as d, COUNT(*) as n')->groupBy('d')->pluck('n', 'd');
            $data['requests'] = [
                'total' => (clone $requests)->count(),
                'new' => (clone $requests)->where('seen', false)->count(),
                'month' => (clone $requests)->where('created_at', '>=', $monthStart)->count(),
                'last_month' => (clone $requests)->whereBetween('created_at', [$lastMonthStart, $monthStart])->count(),
                'avg' => (int) round((clone $requests)->avg('estimate') ?? 0),
                'pipeline' => (int) (clone $requests)->where('created_at', '>=', $monthStart)->sum('estimate'),
                'latest' => (clone $requests)->latest()->limit(5)->get(),
                'daily' => collect(range(29, 0))->mapWithKeys(function ($i) use ($now, $daily) {
                    $day = $now->copy()->subDays($i)->toDateString();
                    return [$day => (int) ($daily[$day] ?? 0)];
                }),
            ];
            // Most requested company types, read from the saved calculator lines.
            $data['requests']['types'] = \App\Models\CostRequest::latest()->limit(500)->get(['selections'])
                ->flatMap(fn ($r) => collect($r->selections)->where('group', 'jurisdiction')->pluck('title'))
                ->countBy()->sortDesc()->take(4);
        }

        if (can_do('invoices')) {
            $paid = \App\Models\Invoice::where('status', 'paid');
            $monthly = \App\Models\Invoice::where('status', 'paid')->where('issue_date', '>=', $now->copy()->subMonths(5)->startOfMonth())
                ->get(['issue_date', 'total'])->groupBy(fn ($i) => $i->issue_date->format('Y-m'))->map->sum('total');
            $data['invoices'] = [
                'paid_month' => (float) (clone $paid)->where('issue_date', '>=', $monthStart)->sum('total'),
                'paid_last_month' => (float) (clone $paid)->whereBetween('issue_date', [$lastMonthStart, $monthStart->copy()->subDay()])->sum('total'),
                'paid_total' => (float) (clone $paid)->sum('total'),
                'unpaid' => (float) \App\Models\Invoice::where('status', 'unpaid')->sum('total'),
                'unpaid_count' => \App\Models\Invoice::where('status', 'unpaid')->count(),
                'overdue_count' => \App\Models\Invoice::where('status', 'unpaid')->whereNotNull('due_date')->whereDate('due_date', '<', $now)->count(),
                'latest' => \App\Models\Invoice::latest('issue_date')->latest('id')->limit(5)->get(),
                'monthly' => collect(range(5, 0))->mapWithKeys(function ($i) use ($now, $monthly) {
                    $m = $now->copy()->subMonths($i);
                    return [$m->translatedFormat('M') => (float) ($monthly[$m->format('Y-m')] ?? 0)];
                }),
            ];
        }

        if (can_do('contact')) {
            $data['messages'] = [
                'new' => \App\Models\Contact::where('seen', 'no')->count(),
                'month' => \App\Models\Contact::where('created_at', '>=', $monthStart)->count(),
                'latest' => \App\Models\Contact::latest()->limit(5)->get(),
            ];
        }

        $data['content'] = [
            'services' => \App\Models\Service::selectRaw('category, COUNT(*) as n')->groupBy('category')->pluck('n', 'category'),
            'posts' => \App\Models\Blog::count(),
            'partners' => \App\Models\Client::count(),
            'subscribers' => \App\Models\Newsletter::count(),
        ];

        return $data;
    }

    public function not_allow() {
        return view('admin.home.deny');
    }
}
