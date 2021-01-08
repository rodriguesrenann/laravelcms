<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Visitor;
use App\Models\Page;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request) {
        //Intervalo do form
        $interval = $request->input([
            'interval'
        ]);
        if($interval > 120) {
            $interval = 120;
        }

        $dateInterval = date('Y-m-d H:i:s', strtotime('-'.$interval.' days'));

        //Pegar visitantes
        $visitors = Visitor::where('date_access', '>=', $dateInterval)->count();
        

        //Pegar usuarios online

        $dateLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $dateLimit)->groupBy('ip')->get();
        $onlineCount = count($onlineList);

        //Páginas criadas
        $pages = Page::count();

        //Usuários registrados
        $users = User::count();

        //Dados do gráfico
        $visitsAll = Visitor::selectRaw('page, count(page) as c')->where('date_access', '>=', $dateInterval)->groupBy('page')->get();
        $pagePie = [];
        foreach($visitsAll as $visits) {
            $pagePie[$visits['c']] = $visits['page'];
        }
        $pageValues = json_encode(array_keys($pagePie));
        $pageLabels = json_encode(array_values($pagePie));

        return view('admin.home', [
            'visitors' => $visitors,
            'onlineUsers' => $onlineCount,
            'pages' => $pages,
            'users' => $users,
            'pageValues' => $pageValues,
            'pageLabels' => $pageLabels,
            'interval' => $interval
        ]);
    }
}
