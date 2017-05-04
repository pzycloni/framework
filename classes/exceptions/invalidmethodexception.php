<?php

	class InvalidMethodException extends DefaultException {

		public function __construct($exception) {

			DefaultException::__construct($exception);
		}

	}