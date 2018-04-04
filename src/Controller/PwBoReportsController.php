<?php

App::uses('LoginController', 'Controller');
App::uses('Key', 'Vendor');
App::uses('jwt', 'Utility');

/**
 * CakePHP PwBoPaymentController
 *
 * @author vinay
 *
 */
class PwBoReportsController
        extends LoginController {

    public function reports() {
        $this->loadModel('PaymentRequest');
        $reportData = '';
        try {
            if ($this->request->is('post') && isset($this->request->data['showreports_flag']) && $this->request->data['showreports_flag'] == 'show_reports') {
                $reqData = $this->request->data['filter_data'];
                $filterdata = explode(",", $reqData);
                if (count($filterdata) == 2) {
                    $reportData = $this->PaymentRequest->getReportsData($filterdata[0], $filterdata[1]);
                } else {
                    throw new Exception("Something went wrong. Please try again later.");
                }
                $this->ResponseArr['reportData'] = $reportData;
            }
        } catch (Exception $ex) {
            $this->ResponseArr['msg'] = $ex->getMessage();
        }
    }

}
