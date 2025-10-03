<?php
// เชื่อมต่อฐานข้อมูล
include 'condb.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === "GET") {
        // ✅ ดึงข้อมูลลูกค้าทั้งหมด
        $stmt = $conn->prepare("SELECT student_id, first_name, last_name, email, phone FROM students ORDER BY student_id ASC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "data" => $result]);
    }

    elseif ($method === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["student_id"])) {
        echo json_encode(["success" => false, "message" => "ไม่พบค่า student_id"]);
        exit;
    }

    $student_id = intval($data["student_id"]);

    // ตรวจสอบว่ามีการส่ง password มาไหม
    if (!empty($data["password"])) {
        // เข้ารหัสรหัสผ่านใหม่
        $password_01 = password_hash($data["password"], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE students 
                                SET first_name = :first_name, 
                                    last_name = :last_name, 
                                    email = :email, 
                                    phone = :phone, 
                                  
                                WHERE student_id = :id");

        $stmt->bindParam(":first_name", $data["first_name"]);
        $stmt->bindParam(":last_name", $data["last_name"]);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":phone", $data["phone"]);
       
        $stmt->bindParam(":id", $student_id, PDO::PARAM_INT);

    } else {
        // กรณีไม่ได้แก้ไข password
        $stmt = $conn->prepare("UPDATE students 
                                SET first_name = :first_name, 
                                    last_name = :last_name, 
                                    email = :email, 
                                    phone = :phone, 
                                 
                                WHERE student_id = :id");

        $stmt->bindParam(":first_name", $data["first_name"]);
        $stmt->bindParam(":last_name", $data["last_name"]);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":phone", $data["phone"]);
   
        $stmt->bindParam(":id", $student_id, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "แก้ไขข้อมูลเรียบร้อย"]);
    } else {
        echo json_encode(["success" => false, "message" => "ไม่สามารถแก้ไขข้อมูลได้"]);
    }
}
    elseif ($method === "DELETE") {
        // ✅ ลบข้อมูลลูกค้าตาม customer_id
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["student_id"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า student_id"]);
            exit;
        }

        $student_id = intval($data["student_id"]);

        $stmt = $conn->prepare("DELETE FROM students WHERE student_id = :id");
        $stmt->bindParam(":id", $student_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ลบข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Method ไม่ถูกต้อง"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}