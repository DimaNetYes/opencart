<?php
class ControllerModuleNewBanner extends Controller
{
    private $error = array();

    public function index(){
        $this->language->load('module/newBanner');

        $this->document->setTitle($this->language->get('heading_title'));

        // регистрируем модуль
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('newBanner', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
        //заполняем массив данных для отрисовки
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_content_top'] = $this->language->get('text_content_top');
        $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
        $this->data['text_column_left'] = $this->language->get('text_column_left');
        $this->data['text_column_right'] = $this->language->get('text_column_right');

        $this->data['table_image'] = $this->language->get('table_image');

        $this->data['entry_banner'] = $this->language->get('entry_banner');
        $this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_dimension'] = $this->language->get('entry_dimension');
        $this->data['entry_category'] = $this->language->get('entry_category');
        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_position'] = $this->language->get('entry_position');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_module'] = $this->language->get('button_add_module');
        $this->data['button_remove'] = $this->language->get('button_remove');

        //токен для сессии
        $this->data['token'] = $this->session->data['token'];


        //Сообщения об ошибках
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        //Добавляем хлебные крошки
        $this->data['breadcrumbs'] = array();
        // Добавляем по одной крошки, сначала ссылка на главную страницу
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'), // text_home по всей видимости доступен отовсюду
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        //Добавляем ссылку на список с модулями, прописано в своем языковом файле
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/newBanner', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        //Проверка на вкл/выкл модуля
        if (isset($this->request->post['newBanner_module'])) {
            $this->data['modules'] = $this->request->post['newBanner_module'];
        } elseif ($this->config->get('newBanner_module')) {
            $this->data['modules'] = $this->config->get('newBanner_module');
            print_r($this->data['modules']);
        }


        //подгружаем баннеры из модели в архив
        $this->load->model('newBanner/layout');
        $this->data['layouts'] = $this->model_newBanner_layout->getLayouts();

        $this->load->model('newBanner/newBanner');
        $this->data['newBanners'] = $this->model_newBanner_newBanner->getAll();



        //подключаем шапки, колонки, хедера
        $this->template = 'module/newBanner.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        // передаем данные на отрисовку
        $this->response->setOutput($this->render());

    }

    //так положено
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/NewBanner')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }


    //добавление методов


}