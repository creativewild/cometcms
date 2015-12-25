<?php namespace Comet\Http\Controllers\Admin;

use Comet\Repositories\Contracts\TeamsRepositoryInterface as Teams;
use Comet\Repositories\Contracts\GamesRepositoryInterface as Games;
use Comet\Http\Requests\SaveTeamRequest;
use Comet\Core\Transformers\TeamHistoryTransformer;
use Comet\Core\Transformers\TeamMembersTransformer;
use Comet\Core\Transformers\TeamTransformer;

class TeamsController extends AdminController
{
    use TraitApi;

    protected $teams;

    public function __construct(Teams $teams)
    {
        parent::__construct();

        $this->teams = $teams;
        $this->breadcrumbs->addCrumb('Squads', 'teams');
    }

    public function index()
    {
        $template = [
            'data'      => $this->teams->all(),
            'pageTitle' => 'Squads'
        ];

        return view('admin.teams.index', $template);
    }

    public function create(Games $games)
    {
        $this->breadcrumbs->addCrumb('New', 'new');

        $template = [
            'team'      => null,
            'modelData' => 'null',
            'games'     => $games->all(),
            'pageTitle' => 'Create new squad',
            'history'   => null
        ];

        return view('admin.teams.form', $template);
    }

    public function save(SaveTeamRequest $request)
    {
        $data = [
            'name'        => $request->get('name'),
            'game_id'     => $request->get('gameId'),
            'description' => $request->get('description'),
            'roster'      => $request->get('roster'),
        ];

        try {
            $team = $this->teams->insert($data);
            $this->setMessage('Squad saved successfully!');

            return $this->respondWithItem($team, new TeamTransformer());
        }
        catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function edit($id, Games $games)
    {
        $this->breadcrumbs->addCrumb('Edit squad', 'edit');

        $team = $this->teams->get($id);

        $template = [
            'team'      => $team,
            'pageTitle' => 'Editing a squad',
            'modelData' => $this->teams->getTeamData($id),
            'games'     => $games->all(),
            'history'   => $this->teams->getMembersHistory($id)
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        $data = [
            'name'        => $request->get('name'),
            'game_id'     => $request->get('gameId'),
            'description' => $request->get('description'),
            'roster'      => $request->get('roster'),
        ];

        try {
            $team = $this->teams->update($id, $data);
            $this->setMessage('Squad updated successfully!');

            return $this->respondWithItem($team, new TeamTransformer());
        }
        catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        if ($this->teams->delete($id)) {
            $this->alerts->alertSuccess('Squad deleted successfully!');
        }
        else {
            $this->alerts->alertError('Unable to delete squad!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/teams');
    }

    public function get($teamID)
    {
        $data = $this->teams->getTeamData($teamID);
        $data['history'] = $this->teams->getMembersHistory($teamID);

        return $this->respondWithItem($data, new TeamTransformer());
    }

    public function getHistory($teamID)
    {
        $data = $this->teams->getMembersHistory($teamID);

        return $this->respondWithCollection($data, new TeamHistoryTransformer());
    }
}
