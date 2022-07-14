<?php

namespace App;

enum LogLevel
{
	case Emergency;
	case Alert;
	case Critical;
	case Error;
	case Warning;
	case Notice;
	case Info;
	case Debug;
}