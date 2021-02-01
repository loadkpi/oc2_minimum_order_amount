<?php
class ControllerExtensionModuleMinimalOrderAmount extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/minimal_order_amount');
        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $data['value_amount_value'] = $this->request->post['module_minimal_order_amount_value_amount_value'];
            $data['value_error_msg']  = $this->request->post['module_minimal_order_amount_value_error_msg'];

            if ($this->validate()) {
                $this->model_setting_setting->editSetting('module_minimal_order_amount', $this->request->post);
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true));
            }
        } else {
            $minimal_order_amount = $this->model_setting_setting->getSetting('module_minimal_order_amount');

            $data['value_amount_value'] = (isset($minimal_order_amount['module_minimal_order_amount_value_amount_value'])) ? $minimal_order_amount['module_minimal_order_amount_value_amount_value'] : 0;
            $data['value_error_msg']  = (isset($minimal_order_amount['module_minimal_order_amount_value_error_msg'])) ? $minimal_order_amount['module_minimal_order_amount_value_error_msg'] : $this->language->get('value_error_msg');
        }

        $data['store_currency'] = $this->config->get('config_currency');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['amount_value'])) {
            $data['amount_value'] = $this->error['amount_value'];
        } else {
            $data['amount_value'] = '';
        }

        if (isset($this->error['error_msg'])) {
            $data['error_msg'] = $this->error['error_msg'];
        } else {
            $data['error_msg'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/minimal_order_amount', 'user_token=' . $this->session->data['user_token'], true),
        );

        $data['action'] = $this->url->link('extension/module/minimal_order_amount', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/minimal_order_amount', $data));

    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/minimal_order_amount')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['module_minimal_order_amount_value_amount_value']) {
            $this->error['amount_value'] = $this->language->get('error_amount_value');
        }

        if (!is_numeric($this->request->post['module_minimal_order_amount_value_amount_value'])) {
            $this->error['amount_value'] = $this->language->get('error_int_amount_value');
        }

        if (!$this->request->post['module_minimal_order_amount_value_error_msg']) {
            $this->error['error_msg'] = $this->language->get('error_error_msg');
        }

		return !$this->error;
    }
}