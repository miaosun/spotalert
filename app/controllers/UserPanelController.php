<?php 
class UserPanelController extends BaseController {
	
	/* show the usercontrol panel */
	public function show() {

		return View::make('user.controlpanel');	
	}
	
	/* update user profile data  */
	public function updateprofile() {
		// FIXME do the function to update profile data
		return View::make('user.controlpanel', array('msg' => 'Teste :update with sucess!'));
	}
}