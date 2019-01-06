<?php
namespace App\Http\Controllers\taskController\pi;

use App\Http\Controllers\taskController\Flugs\booking\BookingFulgs;
use App\Http\Controllers\taskController\Flugs\LastActionFlugs;
use App\Http\Controllers\taskController\Flugs\JobIdFlugs;
use App\Http\Controllers\taskController\Flugs\HeaderType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MxpPi;
use Session;
use Carbon;
use Auth;
use DB;

class PiReverseController extends Controller
{

	/**
	 * @return Pi update view page
	 */
	public function piEditView($job_id) {
		$pi_jobid_details = MxpPi::orderBy('id','DESC')			
            ->where([
            	['is_deleted',BookingFulgs::IS_NOT_DELETED],
            	['job_no',$job_id]
            ])
				->first();

		return view('maxim.pi_format.pi_edit_page',compact('pi_jobid_details'));
	}

	public function piEditAction(Request $request) {
		$p_id = isset($request->p_id) ? $request->p_id : '';
		$job_id = isset($request->job_id) ? $request->job_id : '';
		$poCatNo = isset($request->poCatNo) ? $request->poCatNo : '';
		$oos_number = isset($request->oos_number) ? $request->oos_number : '';
		$item_code = isset($request->item_code) ? $request->item_code : '';
		$erp = isset($request->erp) ? $request->erp : '';
		$item_description = isset($request->item_description) ? $request->item_description : '';
		$gmts_color = isset($request->gmts_color) ? $request->gmts_color : '';
		$item_size = isset($request->item_size) ? $request->item_size : '';
		$style = isset($request->style) ? $request->style : '';
		$sku = isset($request->sku) ? $request->sku : '';
		$item_qty = isset($request->item_qty) ? $request->item_qty : '';
		$item_price = isset($request->item_price) ? $request->item_price : '';
		$others_color = isset($request->others_color) ? $request->others_color : '';

		if(!empty($job_id)) {
			$mxp_pi = MxpPi::where('job_no',$job_id)->first();
			$mxp_pi->user_id = Auth::user()->user_id;
			// $mxp_pi->erp_code = $erp;
			// $mxp_pi->item_code = $item_code;
			// $mxp_pi->item_description = $item_description;
			$mxp_pi->oos_number = $oos_number;
			// $mxp_pi->item_size = $item_size;
			// $mxp_pi->item_price = $item_price;
			// $mxp_pi->gmts_color = $gmts_color;
			$mxp_pi->poCatNo = $poCatNo;
			$mxp_pi->sku = $sku;
			$mxp_pi->style = $style;			
			$mxp_pi->item_quantity = $item_qty;
			$mxp_pi->last_action_at = LastActionFlugs::REVERSE_ACTION;
			$mxp_pi->save();

			$jobId = (JobIdFlugs::JOBID_LENGTH - strlen($job_id));
			Session::flash('message', str_repeat(JobIdFlugs::STR_REPEAT,$jobId).$job_id.' succesfully Update.');

		}else {
        Session::flash('error-m', 'Something is wrong');
		}
		return Redirect()->route('pi_reverse_view', $p_id);
	}

	public function piDeleteAction($job_id) {
		if(!empty($job_id)) {
			$mxp_pi = MxpPi::where('job_no',$job_id)->first();
			// $mxp_pi->user_id = Auth::user()->user_id;
			$mxp_pi->is_deleted = BookingFulgs::IS_DELETED;
			$mxp_pi->deleted_user_id = Auth::User()->user_id;
			$mxp_pi->deleted_date_at = Carbon\Carbon::now();
			$mxp_pi->last_action_at = LastActionFlugs::REVERSE_ACTION;
			$mxp_pi->save();

			$jobId = (JobIdFlugs::JOBID_LENGTH - strlen($job_id));
			Session::flash('message', str_repeat(JobIdFlugs::STR_REPEAT,$jobId).$job_id.' succesfully Cancel.');
		}else {
			Session::flash('error-m', 'Something is wrong');
		}

		return Redirect()->back();
		self::print_me($job_id);
	}
}