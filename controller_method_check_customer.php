// เพิ่ม method นี้ใน Controller: application/modules/main/controllers/Main.php

public function checkCustomerInProgress() {
    header('Content-Type: application/json');
    
    $customercode = $this->input->post('customercode');
    
    if (empty($customercode)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'กรุณาระบุรหัสลูกค้า'
        ]);
        return;
    }
    
    // ตรวจสอบว่ามีรายการที่กำลังทำงานอยู่หรือไม่
    // สถานะที่ยังไม่เสร็จสิ้น: 1=รออนุมัติ, 2=กำลังดำเนินการ, 3=ส่งกลับแก้ไข
    $this->db->select('m.*, s.crf_status_name');
    $this->db->from('main as m');
    $this->db->join('crf_status as s', 'm.crf_status_id = s.crf_status_id', 'left');
    $this->db->where('m.crf_customercode', $customercode);
    $this->db->where_in('m.crf_status_id', [1, 2, 3]); // สถานะที่ยังทำงานไม่เสร็จ
    $this->db->order_by('m.crf_id', 'DESC');
    $this->db->limit(1);
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        $row = $query->row();
        echo json_encode([
            'status' => 'in_progress',
            'form_no' => $row->crf_formno,
            'status_name' => $row->crf_status_name,
            'crf_id' => $row->crf_id
        ]);
    } else {
        echo json_encode([
            'status' => 'available',
            'message' => 'สามารถใช้งานได้'
        ]);
    }
}
