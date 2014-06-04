<?php
class HomeController extends Controller {
	public function index() {
        $livros = Livro::find_by_sql('select categoria, count(*) quantidade from livro group by categoria');
		$this->view->assign('livros', $livros);
		$this->view->display('home/index.tpl');
	}

    public function livros($categoria) {
        $livros = Livro::all(array('conditions' => array('categoria = ?', $categoria)));
        $this->view->assign('livros', $livros);
        $this->view->assign('categoria', $categoria);
        $this->view->display('home/livros.tpl');
    }

    public function detalhes($id) {
        $livro = Livro::find($id);
        $this->view->assign('livro', $livro);
        $this->view->display('home/detalhes.tpl');
    }
}
