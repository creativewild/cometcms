<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use Illuminate\Http\Request;

class GamesController extends AdminController {

    protected $games;

    public function __construct(GamesRepositoryInterface $games)
    {
        $this->games = $games;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->games);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Games';

        return view('admin.games.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Create new game';
        $data['maps'] = null;

        return view('admin.games.form', $data);
    }

    public function save(Request $request, MapsRepositoryInterface $maps)
    {
        $game = $this->games->insert([
            'name'  => $request->input('name'),
            'code'  => $request->input('shortcode'),
            'image' => null
        ]);

        if ($game) {
            if ($request->has('image')) {
                // TODO
            }
            if ($request->has('mapname')) {
                $mapNames = $request->input('mapname');
                $totalMaps = count($mapNames);
                for ($i = 0; $i < $totalMaps; $i ++) {
                    if (!empty($mapNames[$i]))
                        $maps->insertMap($mapNames[$i], $game->id, $request->file('mapimage')[$i]);
                }
            }

            $this->alertSuccess('New game created successfully!');
        } else {
            $this->alertError('Game creation failed!');
        }

        return redirect('admin/games')->with('alerts', $this->getAlerts());
    }

    public function edit($id, GamesRepositoryInterface $games, MapsRepositoryInterface $maps)
    {
        $data['game'] = $this->games->get($id);
        $data['pageTitle'] = 'Editing a game';
        $data['maps'] = $maps->getByGame($id);

        return view('admin.games.form', $data);
    }

    public function update($id, Request $request)
    {

    }

}
