<?php namespace Hideyo\Ecommerce\Backend\Controllers;

/**
 * FaqItemController
 *
 * This is the controller of the faqs of the shop
 * @author Matthijs Neijenhuijs <matthijs@hideyo.io>
 * @version 0.1
 */

use App\Http\Controllers\Controller;
use Hideyo\Ecommerce\Backend\Repositories\FaqItemRepositoryInterface;
use Illuminate\Http\Request;
use Notification;
use Datatables;
use Form;

class FaqItemController extends Controller
{
    public function __construct(
        Request $request, 
        FaqItemRepositoryInterface $faq
    ) {
        $this->request = $request;
        $this->faq = $faq;
    }

    public function index()
    {
        if ($this->request->wantsJson()) {

            $query = $this->faq->getModel()->select(
                [
                
                config()->get('hideyo.db_prefix').'faq_item.id', 
                config()->get('hideyo.db_prefix').'faq_item.faq_item_group_id',
                config()->get('hideyo.db_prefix').'faq_item.question', 
                config()->get('hideyo.db_prefix').'faq_item.answer', 
                config()->get('hideyo.db_prefix').'faq_item_group.title as grouptitle']
            )
            ->with(array('faqItemGroup'))
            ->leftJoin(config()->get('hideyo.db_prefix').'faq_item_group', config()->get('hideyo.db_prefix').'faq_item_group.id', '=', config()->get('hideyo.db_prefix').'faq_item.faq_item_group_id')
            ->where(config()->get('hideyo.db_prefix').'faq_item.shop_id', '=', \Auth::guard('hideyobackend')->user()->selected_shop_id);

            $datatables = Datatables::of($query)
            ->addColumn('faqitemgroup', function ($query) {
                return $query->grouptitle;
            })
            ->addColumn('action', function ($query) {
                $deleteLink = Form::deleteajax(url()->route('hideyo.faq.destroy', $query->id), 'Delete', '', array('class'=>'btn btn-default btn-sm btn-danger'));
                $links = '<a href="'.url()->route('hideyo.faq.edit', $query->id).'" class="btn btn-default btn-sm btn-success"><i class="entypo-pencil"></i>Edit</a>  '.$deleteLink;
            
                return $links;
            });

            return $datatables->make(true);

        }
        
        return view('hideyo_backend::faq-item.index')->with('faq', $this->faq->selectAll());
    }

    public function create()
    {
        $groups = $this->faq->selectAllGroups()->pluck('title', 'id')->toArray();
        return view('hideyo_backend::faq-item.create')->with(array('groups' => $groups));
    }

    public function store()
    {
        $result  = $this->faq->create($this->request->all());

        if (isset($result->id)) {
            Notification::success('The faq was inserted.');
            return redirect()->route('hideyo.faq.index');
        }
        
        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
        return redirect()->back()->withInput();
    }

    public function edit($faqItemId)
    {

        $groups = $this->faq->selectAllGroups()->pluck('title', 'id')->toArray();
        return view('hideyo_backend::faq-item.edit')->with(array('faq' => $this->faq->find($faqItemId), 'groups' => $groups));
    }

    public function editSeo($faqItemId)
    {
        return view('hideyo_backend::faq-item.edit_seo')->with(array('faq' => $this->faq->find($faqItemId)));
    }

    public function update($faqId)
    {
        $result  = $this->faq->updateById($this->request->all(), $faqId);

        if (isset($result->id)) {
            if ($this->request->get('seo')) {
                Notification::success('FaqItem seo was updated.');
                return redirect()->route('hideyo.faq.edit_seo', $faqId);
            } elseif ($this->request->get('faq-combination')) {
                Notification::success('FaqItem combination leading attribute group was updated.');
                return redirect()->route('hideyo.faq.{faqId}.faq-combination.index', $faqId);
            } else {
                Notification::success('FaqItem was updated.');
                return redirect()->route('hideyo.faq.edit', $faqId);
            }
        }

        foreach ($result->errors()->all() as $error) {
            Notification::error($error);
        }
        
       
        return redirect()->back()->withInput();
    }

    public function destroy($faqItemId)
    {
        $result  = $this->faq->destroy($faqItemId);

        if ($result) {
            Notification::success('The faq was deleted.');
            return redirect()->route('hideyo.faq.index');
        }
    }
}
