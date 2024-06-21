    <?php
    $RouteLists = [];
    function handleURL()
    {
        $getURL = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI']), 'strlen'));
        unset($getURL[0]);
        return array_values($getURL);
    }

    function route($route, $callback, $middleware = null)
    {
        global $RouteLists;

        $RouteLists[$route] = ['callback' => $callback, 'middleware' => $middleware];
    }
    function post($paramName, $action)
    {
        if (isset($_POST[$paramName])) {
            $action();
        }
    }

    function handleRoute()
    {
        global $RouteLists;

        $URL = handleURL();

        foreach ($RouteLists as $route => $config) {
            $route = array_values(array_filter(explode('/', $route)));
            if (count($URL) == count($route)) {
                $match = true;
                foreach ($route as $key => $value) {
                    if (strpos($value, '{') !== false) {
                        continue;
                    }
                    if ($value !== $URL[$key]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {
                    $callbackParameters = [];

                    foreach ($route as $key => $value) {
                        if (strpos($value, '{') !== false) {
                            $paramName = trim($value, '{}');
                            $callbackParameters[$paramName] = $URL[$key];
                        }
                    }

                    if (isset($config['middleware']) && is_callable($config['middleware'])) {
                        $middlewareResult = call_user_func($config['middleware']);
                        if (!$middlewareResult) {
                            return;
                        }
                    }

                    call_user_func_array($config['callback'], $callbackParameters);
                    return;
                }
            }
        }

        http_response_code(404);
        view('error/page', ['error' => '404 | Route Halaman tidak ditemukan']);
    }

    function view($view, $data = [])
    {
        extract($data);
        $view = VIEW_PATH . $view . '.php';
        if (file_exists($view)) {
            require_once $view;
        } else {
            http_response_code(404);
            view('error/page', ['error' => '404 | File View Tidak Ditemukan']);
        }
    }

    function handleError($message)
    {
        echo "Error: $message";
    }
