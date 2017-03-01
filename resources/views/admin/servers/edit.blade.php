@extends('layouts.shop')

@section('title')
    Редактировать сервер {{ $server->name }}
@endsection

@section('content')
    <div id="content-container">
        <div class="content-header text-center z-depth-1">
            <h1><i class="fa fa-cog fa-spin fa-left-big"></i>Edit Hi-Tech server</h1>
        </div>
        <div id="s-change-name">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3 col-12 text-center">
                        <div class="md-form text-left">
                            <i class="fa fa-refresh prefix"></i>
                            <input type="text" id="server-name" class="form-control">
                            <label for="server-name">Server name</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="s-settings-cat">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                <div class="row">
                    <div class="col-12 text-center s-s-header">
                        <h3>Categories:</h3>
                    </div>
                    <div class="col-sm-6 offset-sm-3 col-12">
                        <div class="all-cat text-left">
                            <div class="s-set-category">
                                <div class="md-form">
                                    <i class="fa fa-dot-circle-o prefix"></i>
                                    <input type="text" id="cat1" class="form-control">
                                    <label for="cat1">Category</label>
                                </div>
                                <button class="btn danger-color"><i class="fa fa-times fa-lg"></i></button>
                            </div>
                            <div class="s-set-category">
                                <div class="md-form">
                                    <i class="fa fa-dot-circle-o prefix"></i>
                                    <input type="text" id="cat1" class="form-control">
                                    <label for="cat1">Category</label>
                                </div>
                                <button class="btn danger-color"><i class="fa fa-times fa-lg"></i></button>
                            </div>
                            <div class="s-set-category">
                                <div class="md-form">
                                    <i class="fa fa-dot-circle-o prefix"></i>
                                    <input type="text" id="cat1" class="form-control">
                                    <label for="cat1">Category</label>
                                </div>
                                <button class="btn danger-color"><i class="fa fa-times fa-lg"></i></button>
                            </div>
                            <div class="s-set-category">
                                <div class="md-form">
                                    <i class="fa fa-dot-circle-o prefix"></i>
                                    <input type="text" id="cat1" class="form-control">
                                    <label for="cat1">Category</label>
                                </div>
                                <button class="btn danger-color"><i class="fa fa-times fa-lg"></i></button>
                            </div>

                            <!--<div class="s-set-category">
                                <span class="s-set-c-name">Lorem ipsum</span>
                                <span class="s-set-c-del"><i class="fa fa-times fa-lg fa-right-big"></i></span>
                            </div>-->
                        </div>

                        <div class="plus-category">
                            <div class="md-form">
                                <i class="fa fa-plus prefix"></i>
                                <input type="text" id="add-cat" class="form-control">
                                <label for="add-cat">New category</label>
                                <button class="btn green btn-block"><i class="fa fa-plus fa-left"></i>Add category</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                        <button class="btn btn-info"><i class="fa fa-check fa-left"></i>Save</button>
                        <button class="btn danger-color"><i class="fa fa-times fa-left"></i>Delete server</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
