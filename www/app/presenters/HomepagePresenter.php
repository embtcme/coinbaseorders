<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {

	public function renderDefault($code = NULL) {
		
	}

	public function actionOrders() {
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		} else {
			if ($this->user->identity->email_confirmation != 'confirmed' || $this->user->identity->coinbase_access_token == NULL) {
				$this->flashMessage('Verify your e-mail and connect with Coinbase before placing orders.');
				$this->redirect($this->home);
			}
		}
	}

	public function actionNewOrder() {
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		} else {
			if ($this->user->identity->email_confirmation != 'confirmed' || $this->user->identity->coinbase_access_token == NULL) {
				$this->flashMessage('Verify your e-mail and connect with Coinbase before placing orders.');
				$this->redirect($this->home);
			}
		}
	}
	
	public function renderAdmin(){
		if(!$this->user->isInRole('ADMIN')){
			$this->flashMessage('Not authorized', 'error');
			$this->redirect($this->home);
		}
	}
	
	public function actionDisconnectFromCoinbase(){
		if($this->user->isLoggedIn()){
			$this->context->authenticator->update($this->user->id, Array(
				'coinbase_access_token' => NULL,
				'coinbase_refresh_token' => NULL,
				'coinbase_expire_time' => NULL,
			));
			$this->flashMessage('Coinbase disconnected. The app will not be able to fulfill any orders until you reconnect it.', 'success');
			$this->redirect($this->home);			
		}
	}

}
