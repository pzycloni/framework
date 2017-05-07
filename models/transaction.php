<?php

	class Transaction {

		/*
			Инициализация необходиммых переменных
		*/
		public function __construct() {

			$this->db = DB::connect();
			// создаем контейнер результата
			$this->result = new Data();
			// устанавливаем токен доступа
			$this->token = Request::get(TOKEN);
			// проверка доступа
			$this->access = $this->checkAvailable();
		}

		/*
			Получение переменной доступа
		*/
		public function getAvailable() {
			return $this->access;
		}

		/*
			Проверка доступа к методам модели по токену
		*/
		public function checkAvailable() {

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

		/*
			Получаем список клиентов,
			чьи заказы еще не приняты, 
			в нужном промежутке
		*/
		public function getListClients($timezone) {
			// поле заказа
			$accepted = Config::get(CLIENTS . "accepted");
			// поля даты и времени заказа
			$time = Config::get(CLIENTS . "time");
			// заказы попадающие во временной интервал
			$orderlist = array();

			$query = new Select(
				[TABLE_CLIENTS],
				[
					Config::get(CLIENTS . "from"),
					Config::get(CLIENTS . "to"),
					Config::get(CLIENTS . "time"),
					Config::get(CLIENTS . "pay")
				],
				"$accepted is null"
			);

			$this->db->get($query);

			$orderstime = $this->db->results()->get($time);
			$orders = $this->db->results()->get();

			foreach ($orderstime as $number => $order) {
				// граница слева
				$left = time() - $timezone * 60 ;
				// граница справа
				$right = time() + $timezone * 60;
				// время заказа в секундах
				$ordertime = strtotime($order);

				if ($left <= $ordertime && $ordertime <= $right) {
					$orderlist[] = $orders[$number];
				}
			}
		
			return $this->result = $orderlist;
		}

		/*
			Получаем список согласившихся клиентов 
		*/
		public function getListAgreements($count) {
			// поле заказа
			$accepted = Config::get(CLIENTS . "accepted");

			$this->db->get(
				TABLE_CLIENTS,
				[
					Config::get(CLIENTS . "from"),
					Config::get(CLIENTS . "to"),
					Config::get(CLIENTS . "time"),
					Config::get(CLIENTS . "pay")
				],
				"{$accepted}='{$this->token}' LIMIT {$count}"
			);

			return $this->result = $this->db->result->get();
		}

		/*
			Отправка предложения клиенту 
		*/
		public function setNewOffer($uid, $payment) {

			// TODO: написать функцию отправки сообщения с предложением пользователю

		}

	}