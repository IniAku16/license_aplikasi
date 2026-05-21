<?php
require_once __DIR__ . "/../config/koneksi.php";
require_once __DIR__ . "/Payment.php";

class ProductModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products ORDER BY order_date ASC";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $application, $agreement, $expired, $harga, $departemen, $email, $foto)
    {
        $sql = "INSERT INTO products (username, application_name, agreement_number, order_date, harga_order, departemen, email_name, foto) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssss", $name, $application, $agreement, $expired, $harga, $departemen, $email, $foto);
        return $stmt->execute();
    }

    public function update($id, $name, $application, $agreement, $expired, $harga, $departemen, $email, $foto)
    {
        $sql = "UPDATE products 
                SET username=?, application_name=?, agreement_number=?, order_date=?, harga_order=?, departemen=?, email_name=?, foto=? 
                WHERE id=?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssssi", $name, $application, $agreement, $expired, $harga, $departemen, $email, $foto, $id);
        return $stmt->execute();
    }

    public function updatePayment($id, $payment_date, $amount)
    {

        $product = $this->getById($id);

        if (!$product) {
            return false;
        }

        $expired_lama = $product['order_date'];
        $new_expired = date("Y-m-d", strtotime($expired_lama . " +1 year"));
        $paymentModel = new PaymentModel($this->db);

        if ($paymentModel->isPaymentExists($id, $payment_date)) {
            return "duplicate_date";
        }

        $this->db->begin_transaction();

        try {
            $saveHistory = $paymentModel->create($id, $payment_date, $amount);

            if (!$saveHistory) {
                throw new Exception("Gagal simpan histori payment");
            }

            $sql = "UPDATE products 
                    SET payment_status='done', payment_date=?, order_date=?, harga_order=?, request_count=0 
                    WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssdi", $payment_date, $new_expired, $amount, $id);

            $updateProduct = $stmt->execute();

            if (!$updateProduct) {
                throw new Exception("Gagal update product");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getProductsByFilter($startDate = null, $endDate = null, $year = null)
    {
        $sql = "SELECT * FROM products WHERE 1=1";

        if (!empty($startDate) && !empty($endDate)) {
            $sql .= " AND order_date BETWEEN '$startDate' AND '$endDate'";
        }

        if (!empty($year)) {
            $sql .= " AND YEAR(order_date) = '$year'";
        }

        $sql .= " ORDER BY order_date ASC";
        return mysqli_query($this->db, $sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function incrementRequestCount($id)
    {
        $sql = "UPDATE products SET request_count = request_count + 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
