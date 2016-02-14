<?php

class ControllerModuleMinimalOrderCost extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('module/minimal_order_cost');
        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $data['value_cost_value'] = $this->request->post['minimal_order_cost_value_cost_value'];
            $data['value_error_msg']  = $this->request->post['minimal_order_cost_value_error_msg'];

            if ($this->validate()) {
                $this->model_setting_setting->editSetting('minimal_order_cost', $this->request->post);
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            }
        } else {
            $minimal_order_cost = $this->model_setting_setting->getSetting('minimal_order_cost');

            $data['value_cost_value'] = (isset($minimal_order_cost['minimal_order_cost_value_cost_value'])) ? $minimal_order_cost['minimal_order_cost_value_cost_value'] : 1000;
            $data['value_error_msg']  = (isset($minimal_order_cost['minimal_order_cost_value_error_msg'])) ? $minimal_order_cost['minimal_order_cost_value_error_msg'] : $this->language->get('value_error_msg');
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['heading_label'] = $this->language->get('heading_label');

        $data['entry_currency']   = $this->language->get('entry_currency');
        $data['entry_cost_value'] = $this->language->get('entry_cost_value');
        $data['entry_error_msg']  = $this->language->get('entry_error_msg');
        $data['tip_error_msg']    = $this->language->get('tip_error_msg');

        $data['placeholder_error_msg'] = $this->language->get('value_error_msg');

        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['store_currency'] = $this->config->get('config_currency');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['cost_value'])) {
            $data['cost_value'] = $this->error['cost_value'];
        } else {
            $data['cost_value'] = '';
        }

        if (isset($this->error['error_msg'])) {
            $data['error_msg'] = $this->error['error_msg'];
        } else {
            $data['error_msg'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/minimal_order_cost', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('module/minimal_order_cost', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/minimal_order_cost.tpl', $data));

    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/minimal_order_cost')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['minimal_order_cost_value_cost_value']) {
            $this->error['cost_value'] = $this->language->get('error_cost_value');
        }

        if (!$this->request->post['minimal_order_cost_value_error_msg']) {
            $this->error['error_msg'] = $this->language->get('error_error_msg');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}