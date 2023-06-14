<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SendMailModel;
use CodeIgniter\API\ResponseTrait;

class SendMailController extends BaseController
{
    use ResponseTrait;

    protected SendMailModel $sendMailModel;

    public function  __construct()
    {
        $this->sendMailModel = new SendMailModel();
    }

    public function view()
    {
        return view('todo');
    }
    public function send()
    {
        $data = $this->request->getJSON();
        $str = $data->str ?? null;

        $result = "";
        if ($str === null) {
            $result = "Email doesn't exist.";
            return $this->respond([
                "msg" => $result
            ]);
        }
        // Find the data from database.
        $todoList = $this->sendMailModel->findAll();

        $text = "";

        $title = "";
        $content = "";

        for ($num = 0; $num < count($todoList); $num++) {
            foreach ($todoList[$num] as $key => $value) {
                if ($key === "t_title") {
                    $title = $value;
                    $text .= "Title: ";
                    $text .= $title;
                    $text .= "\n";
                }
                if ($key === "t_content") {
                    $content = $value;
                    $text .= "Content: ";
                    $text .= $content;
                    $text .= "\n\n";
                }
            }
        }

        $toMail = $str;
        $subject = "ToDOLists";
        $message = $text;
        $headers = "From: lanangel33@gmail.com\r\n";

        if (mail($toMail, $subject, $message, $headers)) {
            $result = "SUCCESS";
        } else {
            $result = "ERROR";
        }

        return $this->respond([
            "msg" => $result
        ]);
    }
}
