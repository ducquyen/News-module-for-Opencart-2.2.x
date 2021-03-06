<?php  
class ControllerModuleNews extends Controller {
	public function index() {
		$this->language->load('module/news');
		$this->load->model('extension/news');
		$this->load->model('tool/image');

		$filter_data = array(
			'page' => 1,
			'limit' => 5,
			'start' => 0,
		);
	 
		$data['heading_title'] = $this->language->get('heading_title');
	 
		$all_news = $this->model_extension_news->getAllNews($filter_data);
	 
		$data['all_news'] = array();
		$data['text_more'] = $this->language->get('text_more');

		foreach ($all_news as $news) {
			if ($news['image']) {
				$image = $this->model_tool_image->resize($news['image'], 60, 60);
			} else {
				$image = '';
			}
			$data['all_news'][] = array (
				'title' 		=> html_entity_decode($news['title'], ENT_QUOTES),
				'description' 	=> (strlen(strip_tags(html_entity_decode($news['short_description'], ENT_QUOTES))) > 250 ? substr(strip_tags(html_entity_decode($news['short_description'], ENT_QUOTES)), 0, 250) . '...' : strip_tags(html_entity_decode($news['short_description'], ENT_QUOTES))),
				'view' 			=> $this->url->link('information/news/news', 'news_id=' . $news['news_id']),
				'img'           => $image,
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($news['date_added']))
			);
		}
	 
		return $this->load->view('module/news', $data);
	}
}