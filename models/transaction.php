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

			$table = [TABLE_CLIENTS];
			$fields = [
					Config::get(CLIENTS . "from"),
					Config::get(CLIENTS . "to"),
					Config::get(CLIENTS . "time"),
					Config::get(CLIENTS . "pay")
			];
			$where = "{$accepted}='{$this->token}' LIMIT {$count}";

			$query = new Select($table, $fields, $where);

			$this->db->get($query);

			return $this->result = $this->db->results()->get();
		}

	}