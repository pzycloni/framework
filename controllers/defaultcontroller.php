<?php

	class DefaultController {

		/**
			* Основная визуализация
			*
			* @param 
		*/
		protected $view;

		/**
			* Подключение к бд
			*
			* @param DB $db
		*/
		protected $db;

		/**
			* Содержит результат выполненого запроса
			*
			* @param Data $result
		*/
		protected $result;

		/**
			* Содержит токен доступа к базе данных 
			*
			* @param string $token
		*/
		protected $token;

		/**
			* Содержит токен доступа к API Telegram 
			*
			* @param string $telegram
		*/
		protected $telegram;

		/**
			* Конструктор
		*/
		public function __construct() {

			$this->db = DB::connect();
			// создаем контейнер результата
			$this->result = new Data();
		}

		/**
			* Создание объекта нужной модели
			*
			* @param string $name
			*
			* @return new object
		*/
		public function model($name) {

			include_once(MODELS . strtolower($name) . '.php');

			return new $name();
		}

		/**
			* Проверяем на существование организации
			*
			* @return bool
		*/
		public function is_available() {

			$this->token = Request::get(TOKEN);

			$table = [TABLE_ORG];
			$field = [Config::get(ORGANIZATIONS . "token")];
			$where = Config::get(ORGANIZATIONS . "token") . "='" . Request::get(TOKEN) . "'";

			$query = new Select($table, $field, $where);

			$this->result->set($this->db->get($query));

			if ($this->db->results()->is_clean() || !$this->db->executed()) {
				return false;
			}

			return true;
		}

		/**
			* Получаем токен Telegram из бд
			*
			* @return string
		*/
		public function getTokenTelegram() {

			$token = Config::get(TELEGRAM . TOKEN);

			$query = new Select(
				[TABLE_TELEGRAM],
				[$token]
			);

			$this->db->get($query);

			return $this->db->results()->first($token);
		}

	}