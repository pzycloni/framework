<?php

	class DefaultController {

		/*
			Основная визуализация
		*/
		protected $view;

		/*
			Подключение к бд
		*/
		protected $db;

		/*
			Содержит результат выполненого запроса
		*/
		protected $result;

		/*
			Переменная доступа к базе данных
		*/
		protected $access;

		/*
			Содержит токен доступа к базе данных 
		*/
		protected $token;

		/*
			Создание объекта нужной модели
		*/
		public function model($name) {

			include_once(MODELS . strtolower($name) . '.php');

			return new $name();
		}

	}