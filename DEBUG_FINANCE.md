# วิธีการ Debug ปัญหาวงเงินโปรแกรม

## ขั้นตอนการตรวจสอบ

### 1. เปิด Developer Console (F12)
   - กด F12 ใน Browser
   - ไปที่แท็บ "Console"

### 2. ทดสอบกรณีที่ 1: กรอกค่าใหม่
   1. กรอกตัวเลขในช่อง "วงเงิน" เช่น `1`
   2. ดูใน Console ควรเห็น:
      ```
      Finance sync - Display: 1 Calc: 1
      ```
   3. กรอก `1000` ควรเห็น:
      ```
      Finance sync - Display: 1,000 Calc: 1000
      ```

### 3. ทดสอบกรณีที่ 2: โหลดข้อมูลจาก Database
   1. เลือกลูกค้าเก่า
   2. ดูใน Console ควรเห็น:
      ```
      Loading from DB - Raw value: 1000
      After format - Display: 1,000 Calc: 1000
      ```

### 4. ทดสอบกรณีที่ 3: ก่อนกด Submit
   1. กรอกข้อมูลให้ครบ
   2. กด Submit
   3. ดูใน Console ควรเห็น:
      ```
      Form submit - Finance Display: 1,000 Finance Calc: 1000
      ```

### 5. ตรวจสอบค่าที่ส่งไปยัง Server
   1. เปิดแท็บ "Network" ใน Developer Tools
   2. กด Submit
   3. คลิกที่ request "savedata"
   4. ดูที่แท็บ "Payload" หรือ "Form Data"
   5. ตรวจสอบว่า:
      - `crf_finance_req_number` = มี comma (เช่น "1,000")
      - `crf_finance_req_number_calc` = ไม่มี comma (เช่น "1000")

## ปัญหาที่อาจพบ

### ปัญหา: ค่าที่บันทึกเป็น 100 แทนที่จะเป็น 1

**สาเหตุที่เป็นไปได้:**

1. **ค่าจาก Database มีปัญหา**
   - ตรวจสอบใน database ว่าค่าที่บันทึกจริงๆ คือเท่าไหร่
   - Run SQL: `SELECT crfcus_moneylimit FROM crfcus_customer WHERE ...`

2. **มีการคูณ 100 ที่ไหนสักแห่ง**
   - ตรวจสอบในฟังก์ชัน `conPrice()` ที่ไฟล์ `application/helpers/convert_helper.php`
   - ดูว่ามีการคูณหรือหารหรือไม่

3. **มีการเซ็ตค่าซ้ำซ้อน**
   - ตรวจสอบว่ามี JavaScript อื่นที่เซ็ตค่าให้ช่องเดียวกันหรือไม่

## ไฟล์ที่แก้ไขแล้ว

1. **assets/js/addth.js**
   - เพิ่มการ sync ค่าทุกครั้งที่มีการเปลี่ยนแปลง (keyup, change, blur, input)
   - เพิ่มการ sync ก่อน submit form
   - เพิ่ม console.log สำหรับ debug

2. **js/custom.js**
   - เพิ่มการ sync ค่าทุกครั้งที่มีการเปลี่ยนแปลง
   - เพิ่มการ sync ก่อน submit form
   - เพิ่ม console.log สำหรับ debug

3. **application/modules/main/views/add_th.php**
   - เปลี่ยน `crf_finance_req_number_calc` เป็น `type="hidden"`

4. **application/modules/main/models/Main_model.php**
   - แก้ไข 3 จุดให้อ่านค่าจาก `crf_finance_req_number_calc` แทน `crf_finance_req_number`

## การทดสอบ

1. Clear browser cache (Ctrl+Shift+Delete หรือ Ctrl+F5)
2. ทดสอบกรอกค่า 1 ในช่องวงเงิน
3. เช็คใน Console ว่าค่า calc เป็น "1" หรือไม่
4. กด Submit
5. ตรวจสอบใน database ว่าค่าที่บันทึกเป็น 1 หรือไม่

## หากยังมีปัญหา

ส่ง screenshot ของ:
1. Console log ทั้งหมด
2. Network tab → Form Data
3. ค่าที่แสดงในช่อง crf_finance_req_number (เปิด type="text" ชั่วคราว)
4. ค่าที่แสดงในช่อง crf_finance_req_number_calc
5. ค่าที่บันทึกใน database
