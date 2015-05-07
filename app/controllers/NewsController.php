<?php

class NewsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$news = News::orderBy('created_at', 'DESC')->get();
        return View::make('admin.news.index', array(
            'news'  => \SbShare\Presenters\NewsPresenter::instances($news),
        ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.news.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
        $validation = Validator::make($data, News::$validation);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        $data['user_id'] = Auth::user()->id;
        $news = News::create($data);

        return Redirect::route('admin.news.index')->withFlashMessage('Новость добавлена');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$news = News::find($id);

        if (!$news) {
            return Redirect::route('admin.news.index')->withFlashMessage('Новость не найдена.');
        }

        return View::make('admin.news.edit', array(
            'news'  => $news,
        ));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::only(array('news'));
        $validation = Validator::make($data, News::$validation);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        $news = News::find($id);
        if (!$news) {
            return Redirect::route('admin.news.index')->withFlashMessage('Новость не найдена.');
        }

        $news->update($data);
        return Redirect::route('admin.news.index')->withFlashMessage('Новость обновлена.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
