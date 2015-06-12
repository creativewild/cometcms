<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Http\Request;

class TeamsController extends AdminController {

    protected $teams;

    public function __construct(TeamsRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        $data['data'] = $this->teams->all();

        $data['pageTitle'] = 'Squads';

        return view('admin.teams.index', $data);
    }

    public function create()
    {
        $data['team'] = null;
        $data['pageTitle'] = 'Create new squad';

        return view('admin.teams.form', $data);
    }

    public function save(Request $request)
    {
        
    }

    public function edit($id)
    {
        $data['team'] = $this->teams->get($id);
        $data['pageTitle'] = 'Editing an squad';

        return view('admin.teams.form', $data);
    }

    public function update($id, Request $request)
    {
        
    }

    public function getRoster($teamID)
    {
        $this->teams->all();
    }

}
