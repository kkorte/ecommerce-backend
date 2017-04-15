<?php namespace Hideyo\Backend\Controllers;

use App\Http\Controllers\Controller;
use Hideyo\Backend\Repositories\GeneralSettingRepositoryInterface;

use Illuminate\Http\Request;
use Notification;
use Form;

class GeneralSettingController extends Controller
{

    public function __construct(Request $request, GeneralSettingRepositoryInterface $generalSetting)
    {
        $this->request = $request;
        $this->generalSetting = $generalSetting;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->generalSetting->getModel()->select(
                [
                
                'id',
                'name', 'value']
            )->where('shop_id', '=', \Auth::guard('hideyobackend')->user()->selected_shop_id);
            
            $datatables = \Datatables::of($query)->addColumn('action', function ($query) {
                $delete = Form::deleteajax(url()->route('hideyo.general-setting.destroy', $query->id), 'Delete', '', array('class'=>'btn btn-sm btn-danger'));
                $link = '<a href="'.url()->route('hideyo.general-setting.edit', $query->id).'" class="btn btn-sm btn-success"><i class="fi-pencil"></i>Edit</a>  '.$delete;
                return $link;
            });





            return $datatables->make(true);

        } else {
            return view('hideyo_backend::general-setting.index')->with('generalSetting', $this->generalSetting->selectAll());
        }
    }

    public function create()
    {
        return view('hideyo_backend::general-setting.create')->with(array());
    }

    public function store()
    {
        $result  = $this->generalSetting->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The general setting was inserted.');
            return redirect()->route('hideyo.general-setting.index');
        }
            
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        return view('hideyo_backend::general-setting.edit')->with(array('generalSetting' => $this->generalSetting->find($id)));
    }

    public function update($id)
    {
        $result  = $this->generalSetting->updateById($this->request->all(), $id);

        if (isset($result->id)) {
            Notification::success('The general setting was updated.');
            return redirect()->route('hideyo.general-setting.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $result  = $this->generalSetting->destroy($id);
        if ($result) {
            Notification::error('The general setting was deleted.');
            return redirect()->route('hideyo.general-setting.index');
        }
    }
}