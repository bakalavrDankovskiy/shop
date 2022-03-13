<?php

namespace App\Models;

class Product extends Model
{
    public function insert($data): bool
    {
        $this->db->query('INSERT INTO products (id, title, price, pic_source)
        VALUES (:id, :title, :price, :pic_source)');

        /**
         * Bind values
         **/
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':pic_source', $data['pic_source']);

        /**
         * Execute
         */
        $result = (bool)$this->db->execute();

        if (!empty($data['categories'])) {
            $categoryIds = [];
            foreach ($data['categories'] as $category) {
                $categoryIds[] = $this->getCategoryId($category);
            }
            foreach ($categoryIds as $categoryId) {
                $this->addCategory($data['id'], $categoryId);
            }
        }

        return $result;
    }

    public function update($data): bool
    {
        $this->db->query(
            'UPDATE products 
                  SET 
                      title = :title,
                      price = :price,
                      pic_source = :pic_source
                  WHERE id = :id'
        );

        /**
         * Bind values
         **/
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':pic_source', $data['pic_source']);

        /**
         * Execute
         */
        $result = (bool)$this->db->execute();

        $this->deleteCategories($data['id']);

        if (!empty($data['categories'])) {
            $categoryIds = [];
            foreach ($data['categories'] as $category) {
                $categoryIds[] = $this->getCategoryId($category);
            }
            foreach ($categoryIds as $categoryId) {
                $this->addCategory($data['id'], $categoryId);
            }
        }

        return $result;
    }

    public function deleteCategories(int $id): bool
    {
        $this->db->query('DELETE FROM product_category WHERE product_id = :id ');
        $this->db->bind(':id', $id);

        return (bool)$this->db->execute();
    }

    public function getCategoryId(string $categoryTitle): int
    {
        $this->db->query('SELECT id FROM categories WHERE title = :title');
        $this->db->bind(':title', $categoryTitle);

        return $this->db->single()->id;
    }

    public function addCategory(int $productId, int $categoryId): bool
    {
        $this->db->query('INSERT INTO product_category (product_id, category_id) 
        VALUES (:product_id, :category_id)');

        $this->db->bind(':product_id', $productId);
        $this->db->bind(':category_id', $categoryId);

        return (bool)$this->db->execute();
    }

    public function where(int $minPrice, int $maxPrice, array $categories)
    {
        $query = "SELECT *
        FROM (SELECT p.id                  as id,
             p.title               as title,
             p.price               as price,
             p.pic_source          as pic_source,
             GROUP_CONCAT(c.title) as categories
        FROM products AS p
               LEFT JOIN product_category pc ON p.id = pc.product_id
               LEFT JOIN categories AS c on pc.category_id = c.id
        GROUP BY p.id
        ) as raw_products
        WHERE price > :min_price
         and price < :max_price
        ";
        if (!empty($categories)) {
            foreach ($categories as $category) {
//                $query .= " and categories like '" . $category . "'";
                $query .= ' and categories RLIKE "(^|,)' . $category . '($|,)"';
            }
        }

        $this->db->query($query);

        /**
         * Bind values
         **/
        $this->db->bind(':min_price', $minPrice);
        $this->db->bind(':max_price', $maxPrice);

        return $this->db->resultSet();
    }

    public function find(int $id)
    {
        $query = "SELECT *
        FROM (SELECT p.id                  as id,
             p.title               as title,
             p.price               as price,
             p.pic_source          as pic_source,
             GROUP_CONCAT(c.title) as categories
        FROM products AS p
               LEFT JOIN product_category pc ON p.id = pc.product_id
               LEFT JOIN categories AS c on pc.category_id = c.id
        GROUP BY p.id
        ) as raw_products
        WHERE id = :id";

        if ($id <= 0) return false;

        $this->db->query($query);

        /**
         * Bind id value
         **/
        $this->db->bind(':id', $id);

        $product = $this->db->single();

        return !empty($product) ? $product : false;
    }

    public function delete(int $id): bool
    {
        $this->db->query('DELETE FROM product_category WHERE product_id=:id; DELETE FROM products WHERE id=:id');
        $this->db->bind(':id', $id);

        return (bool)$this->db->execute();
    }
}