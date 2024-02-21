<?php

if (!function_exists("create_response")) {
    function create_response()
    {
        $response = new stdClass;
        $response->status = FALSE;
        $response->status_code = 404;
        $response->data = [];
        $response->message = "Not Found";

        return $response;
    }
}

if (!function_exists("response_success_default")) {
    function response_success_default($message, $id = FALSE, $next_url = FALSE)
    {
        $response = create_response();
        $response->status = TRUE;
        $response->status_code = 200;
        if ($id) {
            $response->data = [
                "id" => $id
            ];
        }

        $response->message = $message;
        if ($next_url) {
            $response->next_url = $next_url;
        }

        return $response;
    }
}

if (!function_exists("response_errors_default")) {
    function response_errors_default()
    {
        $response = new stdClass;
        $response->status = FALSE;
        $response->status_code = 500;
        $response->data = [];
        $response->message = "Terjadi kesalahan server!";

        return $response;
    }
}

if (!function_exists("response_json")) {
    function response_json($response)
    {
        return response()->json($response, $response->status_code);
    }
}

if (!function_exists("response_data")) {
    function response_data($data)
    {
        $response = create_response();

        if (count($data) > 0) {
            $response->status = TRUE;
            $response->status_code = 200;
            $response->message = "Found!";
            $response->data = $data;
        }

        return $response;
    }
}

if (!function_exists("random_string")) {
    function random_string($length = 10)
    {
        return \Illuminate\Support\Str::random($length);
    }
}

if (!function_exists("form_delete")) {
    function form_delete($formID, $route)
    {
        $html = "<form id='$formID' action='$route' method='POST' with-submit-crud class='d-inline-block'>";
        $html .= "<input type='hidden' name='_token' value='" . csrf_token() . "'>";
        $html .= "<input type='hidden' name='_method' value='DELETE'>";

        $html .= "<button class='btn btn-danger btn-sm' type='button' onclick=\"CORE.promptForm('$formID', 'Yakin ingin menghapus data ini?')\">Hapus</button>";
        $html .= "</form>";

        return $html;
    }
}

if (!function_exists("check_authorized")) {
    function check_authorized($module_code)
    {
        return (new \App\Services\AuthorizationService)->check_authorization($module_code);
    }
}
