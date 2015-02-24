<?php

	class errorController extends Controller
	{
        public function Index()
        {
			global $layout;
			$this->Render(null, $layout['main']);
        }
	}