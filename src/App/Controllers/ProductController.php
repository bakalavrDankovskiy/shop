<?php

namespace App\Controllers;

use App\Exception\NotFoundException;
use App\Models\Product;
use App\View\View;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function save()
    {
        /**
         * $_POST data filtration
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (empty($_POST['title'])) {
            flash("addProduct", "Empty title", "danger");
            redirect("/admin/products/add");
        }
        if (empty($_POST['price'])) {
            flash("addProduct", "Empty price", "danger");
            redirect("/admin/products/add");
        }
        if (empty($_FILES['product-photo']['name'])) {
            flash("addProduct", "Empty product photo", "danger");
            redirect("/admin/products/add");
        }

        $data = [
            'title' => trim($_POST['title']),
            'price' => trim($_POST['price']),
            'categories' => array_map('trim', $_POST['categories'] ?? []),
        ];

        $patterns = [
            'title' => '/^(?=.{1,50}$)([a-zA-Zа-яА-Я]+[-_\s]?)+/is',
            'price' => '/^\s*\d{1,6}\s*$/',
        ];

        foreach ($data as $key => $value) {
            if ($key == 'categories') {
                continue;
            }
            if (!preg_match($patterns[$key], $value)) {
                flash("addProduct", "Invalid format for $key", "danger");
                redirect("/admin/products/add");
            }
        }

        $picName = $_FILES['product-photo']['name'];
        $picType = $_FILES['product-photo']['type'];
        $picTempPath = $_FILES['product-photo']['tmp_name'];
        $appliedFormat = ['image/jpg', 'image/jpeg', 'image/png'];

        if (!in_array($picType, $appliedFormat)) {
            flash("addProduct", "Wrong product photo format", "danger");
            redirect("/admin/products/add");
        }
        /**
         * Установка pic_source
         */
        $maxId = $this->productModel->getLastId('products');
        $data['id'] = ++$maxId;
        preg_match('/\.(jpg|jpeg|png)$/', $picName, $matches);
        $format = $matches[0];
        $data['pic_source'] = $data['title'] . "-" . $data['id'] . $format;

        try {
            $this->productModel->insert($data);
            /*
             * Загрузка картинки на сервер
             */
            move_uploaded_file($picTempPath, PIC_UPLOAD_PATH . $data['pic_source']);
            flash("addProduct", "Продукт успешно добавлен!", "success");
            redirect("/admin/products/add");
        } catch (\PDOException $e) {
            flash("addProduct", "Error: " . $e->errorInfo[1], "danger");
            redirect("/admin/products/add");
        }
    }

    public function update()
    {
        /**
         * $_POST data filtration
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (empty($_POST['id'])) {
            flash("editProduct", "Empty id for product's editing", "danger");
            redirect("/");
        }

        $data['id'] = $_POST['id'];

        if (empty($_POST['title'])) {
            flash("editProduct", "Empty title", "danger");
            redirect("/admin/products/edit?id=" . $data['id']);
        }
        if (empty($_POST['price'])) {
            flash("editProduct", "Empty price", "danger");
            redirect("/admin/products/edit?id=" . $data['id']);
        }

        $data = [
            'id' => $data['id'],
            'title' => trim($_POST['title']),
            'price' => trim($_POST['price']),
            'categories' => array_map('trim', $_POST['categories'] ?? []),
        ];

        $patterns = [
            'title' => '/^(?=.{1,50}$)([a-zA-Zа-яА-Я]+[-_\s]?)+/is',
            'price' => '/^\s*\d{1,6}\s*$/',
        ];

        foreach ($data as $key => $value) {
            if ($key == 'id' || $key == 'categories') {
                continue;
            }

            if (!preg_match($patterns[$key], $value)) {
                flash("editProduct", "Invalid format for $key", "danger");
                redirect("/admin/products/edit?id=" . $data['id']);
            }
        }

        //Получение адреса старой картинки на сервере
        $picSource = $this->productModel->find($data['id'])->{'pic_source'};

        if (!empty($_FILES['product-photo']['name'])) {
            $picName = $_FILES['product-photo']['name'];
            $picType = $_FILES['product-photo']['type'];
            $picTempPath = $_FILES['product-photo']['tmp_name'];
            $appliedFormat = ['image/jpg', 'image/jpeg', 'image/png'];

            if (!in_array($picType, $appliedFormat)) {
                flash("editProduct", "Wrong product photo format", "danger");
                redirect("/admin/products/edit?id=" . $data['id']);
            }

            preg_match('/\.(jpg|jpeg|png)$/', $picName, $matches);
            $format = $matches[0];

            $data['pic_source'] = $data['title'] . "-" . $data['id'] . $format;

            try {
                $this->productModel->update($data);

                /**
                 * Удаление старой картинки с сервера
                 */
                unlink(PIC_UPLOAD_PATH . $picSource);

                /*
                 * Загрузка картинки на сервер
                 */
                move_uploaded_file($picTempPath, PIC_UPLOAD_PATH . $data['pic_source']);

                flash("editProduct", "Карта продукта успешно изменена!", "success");
                redirect("/admin/products/edit?id=" . $data['id']);
            } catch (\PDOException $e) {
                flash("editProduct", "Error: " . $e->errorInfo[1], "danger");
                redirect("/admin/products/edit?id=" . $data['id']);
            }
        } else {
            preg_match('/\.(jpg|jpeg|png)$/', $picSource, $matches);
            $format = $matches[0];
            $data['pic_source'] = $data['title'] . "-" . $data['id'] . $format;

            rename(PIC_UPLOAD_PATH . $picSource, PIC_UPLOAD_PATH . $data['pic_source']);

            try {
                $this->productModel->update($data);

                flash("editProduct", "Карта продукта успешно изменена!", "success");
                redirect("/admin/products/edit?id=" . $data['id']);
            } catch (\PDOException $e) {
                flash("editProduct", "Error: " . $e->errorInfo[2], "danger");
                redirect("/admin/products/edit?id=" . $data['id']);
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        if (is_int($id)) {
            return json_encode(false);
        }
        try {
            $result = $this->productModel->delete($id);
        } catch (\PDOException $e) {
            die(json_encode([
                'value' => 0,
                'error' => $e->getMessage(),
                'data' => null,
            ]));
        }
        return json_encode($result);
    }

    public function get()
    {
        /**
         * $_GET data filtration
         */
        $params = $_GET;

        $minPrice = array_key_exists('minPrice', $params) ? $params['minPrice'] : MIN_PRICE;

        $maxPrice = array_key_exists('maxPrice', $params) ? $params['maxPrice'] : MAX_PRICE;

        if (array_key_exists('categories', $params)) {
            $categories = is_string($params['categories']) ? explode(',', $params['categories']) : [];
        } else {
            $categories = [];
        }

        try {
            $products = $this->productModel->where($minPrice, $maxPrice, $categories);

            if(!empty($products)){
                return json_encode($products);
            } else {
                return json_encode(['error']);
            }

        } catch (\PDOException $e) {
            redirect("/notFound");
        }
    }

    public function findById()
    {
        if (isset($_GET['id']) && preg_match('/^\d+$/', $_GET['id'])) {
            $product = $this->productModel->find($_GET['id']);

            if (!empty($product)) {
                return new View('edit', ['product' => $product]);
            }
        }
        throw new NotFoundException();
    }
}