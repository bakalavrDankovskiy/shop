<?php

namespace App\Models;

class Order extends Model
{
    public function insert(array $data)
    {
        $this->db->query('INSERT INTO orders (product_id, price, delivery_info) 
        VALUES (:id, :price, :delivery_info)');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':delivery_info', json_encode($data['deliveryInfo']));

        return (bool)$this->db->execute();
    }

    public function get()
    {
        $this->db->query("SELECT * FROM orders");

        return $this->db->resultSet();
    }

    public function changeStatus(int $id, string $status)
    {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        return (bool)$this->db->execute();
    }
}