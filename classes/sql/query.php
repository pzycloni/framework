<?php

	class Query {

		/**
			*Таблицы запроса
			*@var array
		*/
		protected $tables;

		/**
			*Колонки таблиц
			*@var array
		*/
		protected $fields;

		/**
			*Условие запроса
			*@var string
		*/
		protected $where;

		/**
			*Текст запроса
			*@var string
		*/
		protected $query;

		/**
			*Создание объекта
			*@param array $tables
			*@param array $fields
			*@param string $where
		*/
		public function __construct($tables, $fields, $where) {
			
			$this->tables 	= $this->wrap($tables, '`');
			$this->fields 	= $fields;
			$this->where 	= $where;
		}

		/*
			Получение текста запроса
		*/
		public function get() {
			return $this->query;
		}

		/**
			*Оборачиваем элементы массива
			*@param array $args
			*@param string $bracket
		*/
		protected function wrap($args, $bracket = null) {

			if ($bracket) {
				foreach ($args as $key => $value) {
					$temp[$key] = $bracket . $value . $bracket;
				}
				$args = $temp; 
			}

			return $args;
		}

		/**
			*Перевод массива в строку
			*@param array $args
		*/
		protected function compose($args) {

			foreach ($args as $arg) {
				$str .= $arg;
				$str .= ($x < count($args)) ? ' ' : '';
				$x++;
			}

			return $str;
		}
	}