<?php

  class loggedInUser {
	public $email = NULL;
	public $hash_pw = NULL;
	public $user_id = NULL;
	public $first_name = NULL;

      //Logout
      public function userLogOut()
      {
          destroySession("ThisUser");
      }
}
?>