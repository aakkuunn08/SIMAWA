# Panduan Testing Manual - Custom Popup untuk Katalon

## Persiapan Testing

### 1. Jalankan Server
```bash
php artisan serve
```
Server akan berjalan di: http://127.0.0.1:8000

### 2. Login sebagai Admin
- Username: (gunakan akun admin BEM atau UKM)
- Password: (password akun admin)

---

## Checklist Testing

### ✅ Test 1: Tambah Kegiatan Berhasil

**Langkah:**
1. Buka http://127.0.0.1:8000
2. Login sebagai admin
3. Scroll ke bagian Kalender
4. Klik tombol **"+ Tambah Kegiatan"**
5. Isi form:
   - Jadwal: Pilih tanggal
   - Waktu Mulai: 09:00
   - Waktu Selesai: 12:00
   - Kegiatan: "Test Kegiatan Baru"
   - Tempat: "Aula Kampus"
6. Klik tombol **"Simpan"**

**Expected Result:**
- ✅ Popup muncul dengan:
  - Background hijau muda
  - Icon checkmark hijau
  - Title: "Berhasil"
  - Message: Pesan sukses dari server
  - Tombol OK berwarna hijau
  - Tombol Batal TIDAK terlihat
- ✅ Klik OK → Popup hilang
- ✅ Halaman reload setelah 1.5 detik
- ✅ Kegiatan muncul di kalender

**Katalon Elements to Verify:**
- `#customAlertModal` - visible
- `#alertTitle` - text = "Berhasil"
- `#alertMessage` - contains success message
- `#alertOkBtn` - visible, class contains "bg-green-500"
- `#alertCancelBtn` - NOT visible (has "hidden" class)

---

### ✅ Test 2: Edit Kegiatan Berhasil

**Langkah:**
1. Klik pada kegiatan yang ada di kalender
2. Modal detail muncul
3. Klik tombol **"Edit"**
4. Form terbuka dengan data kegiatan
5. Ubah nama kegiatan menjadi "Test Kegiatan Updated"
6. Klik **"Simpan"**

**Expected Result:**
- ✅ Popup success muncul (hijau)
- ✅ Message menunjukkan kegiatan berhasil diupdate
- ✅ Klik OK → Popup hilang
- ✅ Halaman reload
- ✅ Perubahan tersimpan

---

### ✅ Test 3: Hapus Kegiatan - Konfirmasi

**Langkah:**
1. Klik pada kegiatan di kalender
2. Modal detail muncul
3. Klik tombol **"Hapus"**

**Expected Result - Popup Konfirmasi:**
- ✅ Popup muncul dengan:
  - Background orange muda
  - Icon warning triangle orange
  - Title: "Konfirmasi"
  - Message: "Apakah Anda yakin ingin menghapus kegiatan ini?"
  - Tombol OK berwarna orange
  - Tombol **Batal** TERLIHAT (warna abu-abu)

**Katalon Elements to Verify:**
- `#customAlertModal` - visible
- `#alertTitle` - text = "Konfirmasi"
- `#alertMessage` - contains "yakin" and "hapus"
- `#alertOkBtn` - visible, class contains "bg-orange-500"
- `#alertCancelBtn` - visible, NOT hidden

---

### ✅ Test 4: Hapus Kegiatan - Klik Batal

**Langkah:**
1. Lanjutan dari Test 3
2. Pada popup konfirmasi, klik tombol **"Batal"**

**Expected Result:**
- ✅ Popup hilang
- ✅ Modal detail masih terbuka
- ✅ Kegiatan TIDAK terhapus
- ✅ Kegiatan masih ada di kalender

---

### ✅ Test 5: Hapus Kegiatan - Klik OK (Berhasil)

**Langkah:**
1. Klik kegiatan di kalender
2. Klik tombol **"Hapus"**
3. Pada popup konfirmasi, klik tombol **"OK"**

**Expected Result:**
- ✅ Popup konfirmasi hilang
- ✅ Popup success muncul (hijau) dengan message "Kegiatan berhasil dihapus"
- ✅ Klik OK → Popup hilang
- ✅ Halaman reload setelah 1.5 detik
- ✅ Kegiatan hilang dari kalender

---

### ✅ Test 6: Error - Gagal Memuat Detail

**Langkah:**
1. Buka Developer Console (F12)
2. Klik kegiatan di kalender
3. Jika ada error network atau server error

**Expected Result:**
- ✅ Popup error muncul dengan:
  - Background merah muda
  - Icon X merah
  - Title: "Error"
  - Message: "Gagal memuat detail kegiatan"
  - Tombol OK berwarna merah
  - Tombol Batal TIDAK terlihat

**Katalon Elements to Verify:**
- `#customAlertModal` - visible
- `#alertTitle` - text = "Error"
- `#alertMessage` - contains "Gagal memuat"
- `#alertOkBtn` - visible, class contains "bg-red-500"
- `#alertCancelBtn` - NOT visible

---

### ✅ Test 7: Error - Gagal Menyimpan Kegiatan

**Langkah:**
1. Klik **"+ Tambah Kegiatan"**
2. Isi form dengan data invalid (atau simulasikan error server)
3. Klik **"Simpan"**

**Expected Result:**
- ✅ Popup error muncul (merah)
- ✅ Message menunjukkan error yang terjadi
- ✅ Form tetap terbuka (tidak close)
- ✅ Data tidak tersimpan

---

### ✅ Test 8: Verifikasi Element IDs

**Langkah:**
1. Buka Developer Tools (F12)
2. Trigger salah satu popup (success/error/confirm)
3. Inspect element popup

**Expected Result - Semua ID harus ada:**
- ✅ `customAlertModal` - Container utama
- ✅ `alertIcon` - Container icon
- ✅ `alertTitle` - Text title
- ✅ `alertMessage` - Text message
- ✅ `alertOkBtn` - Tombol OK
- ✅ `alertCancelBtn` - Tombol Batal

---

### ✅ Test 9: Visual Testing - Success Popup

**Verifikasi:**
- ✅ Background icon: Hijau muda (#10B981 / bg-green-100)
- ✅ Icon: Checkmark hijau
- ✅ Title: "Berhasil" - Bold, center
- ✅ Message: Center aligned, abu-abu
- ✅ Tombol OK: Hijau (#10B981), text putih
- ✅ Tombol Batal: Hidden
- ✅ Popup center di layar
- ✅ Shadow dan rounded corners

---

### ✅ Test 10: Visual Testing - Error Popup

**Verifikasi:**
- ✅ Background icon: Merah muda (#EF4444 / bg-red-100)
- ✅ Icon: X mark merah
- ✅ Title: "Error" - Bold, center
- ✅ Message: Center aligned, abu-abu
- ✅ Tombol OK: Merah (#EF4444), text putih
- ✅ Tombol Batal: Hidden

---

### ✅ Test 11: Visual Testing - Confirmation Popup

**Verifikasi:**
- ✅ Background icon: Orange muda (#F97316 / bg-orange-100)
- ✅ Icon: Warning triangle orange
- ✅ Title: "Konfirmasi" - Bold, center
- ✅ Message: Center aligned, abu-abu
- ✅ Tombol OK: Orange (#F97316), text putih
- ✅ Tombol Batal: Visible, abu-abu (#E5E7EB)

---

### ✅ Test 12: Responsive Testing

**Langkah:**
1. Resize browser ke berbagai ukuran:
   - Desktop (1920x1080)
   - Tablet (768x1024)
   - Mobile (375x667)
2. Trigger popup di setiap ukuran

**Expected Result:**
- ✅ Popup tetap center di semua ukuran
- ✅ Text readable dan tidak terpotong
- ✅ Tombol tidak overlap
- ✅ Padding dan spacing konsisten

---

### ✅ Test 13: Multiple Popups (Edge Case)

**Langkah:**
1. Trigger popup pertama
2. Sebelum close, coba trigger popup lain (jika memungkinkan)

**Expected Result:**
- ✅ Hanya satu popup yang muncul di satu waktu
- ✅ Popup baru replace popup lama
- ✅ Tidak ada popup yang overlap

---

### ✅ Test 14: Keyboard Navigation

**Langkah:**
1. Trigger popup
2. Coba tekan Enter atau Escape

**Expected Result:**
- ✅ Enter → Sama seperti klik OK
- ✅ Escape → Popup hilang (optional, tergantung implementasi)

---

### ✅ Test 15: Browser Compatibility

**Test di berbagai browser:**
- ✅ Chrome/Edge (Chromium)
- ✅ Firefox
- ✅ Safari (jika tersedia)

**Verifikasi:**
- ✅ Popup muncul dengan benar
- ✅ Styling konsisten
- ✅ Animasi smooth
- ✅ Tombol berfungsi

---

## Katalon Studio - Test Object Setup

### Cara Membuat Test Objects di Katalon:

1. **Buka Katalon Studio**
2. **Klik kanan pada Object Repository → New → Test Object**
3. **Buat test objects berikut:**

#### customAlertModal
```
Name: customAlertModal
Selection Method: CSS Selector
Selector Value: #customAlertModal
```

#### alertTitle
```
Name: alertTitle
Selection Method: CSS Selector
Selector Value: #alertTitle
```

#### alertMessage
```
Name: alertMessage
Selection Method: CSS Selector
Selector Value: #alertMessage
```

#### alertOkBtn
```
Name: alertOkBtn
Selection Method: CSS Selector
Selector Value: #alertOkBtn
```

#### alertCancelBtn
```
Name: alertCancelBtn
Selection Method: CSS Selector
Selector Value: #alertCancelBtn
```

#### alertIcon
```
Name: alertIcon
Selection Method: CSS Selector
Selector Value: #alertIcon
```

---

## Contoh Katalon Test Case Script

```groovy
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI

// Test: Tambah Kegiatan Berhasil
WebUI.openBrowser('http://127.0.0.1:8000')
WebUI.maximizeWindow()

// Login
WebUI.setText(findTestObject('Login/username'), 'admin')
WebUI.setEncryptedText(findTestObject('Login/password'), 'password')
WebUI.click(findTestObject('Login/btnLogin'))

// Navigate to calendar
WebUI.scrollToElement(findTestObject('Dashboard/kalenderSection'), 5)

// Click Tambah Kegiatan
WebUI.click(findTestObject('Dashboard/btnTambahKegiatan'))

// Fill form
WebUI.setText(findTestObject('Form/tanggal_kegiatan'), '2025-12-31')
WebUI.setText(findTestObject('Form/waktu_mulai'), '09:00')
WebUI.setText(findTestObject('Form/waktu_selesai'), '12:00')
WebUI.setText(findTestObject('Form/nama_kegiatan'), 'Test Kegiatan Katalon')
WebUI.setText(findTestObject('Form/tempat'), 'Aula Kampus')

// Submit
WebUI.click(findTestObject('Form/btnSimpan'))

// Verify popup appears
WebUI.waitForElementVisible(findTestObject('Popup/customAlertModal'), 10)
WebUI.verifyElementVisible(findTestObject('Popup/customAlertModal'))

// Verify popup type is success
String okBtnClass = WebUI.getAttribute(findTestObject('Popup/alertOkBtn'), 'class')
WebUI.verifyMatch(okBtnClass, '.*bg-green-500.*', true)

// Verify title
String title = WebUI.getText(findTestObject('Popup/alertTitle'))
WebUI.verifyEqual(title, 'Berhasil')

// Verify message contains success text
String message = WebUI.getText(findTestObject('Popup/alertMessage'))
WebUI.verifyMatch(message, '.*berhasil.*', true)

// Verify Cancel button is hidden
WebUI.verifyElementNotVisible(findTestObject('Popup/alertCancelBtn'))

// Click OK
WebUI.click(findTestObject('Popup/alertOkBtn'))

// Wait for popup to disappear
WebUI.waitForElementNotVisible(findTestObject('Popup/customAlertModal'), 5)

// Wait for page reload
WebUI.delay(2)

// Verify kegiatan appears in calendar
WebUI.verifyElementPresent(findTestObject('Calendar/eventTestKegiatan'), 5)

WebUI.closeBrowser()
```

---

## Troubleshooting

### Popup tidak muncul
- Check console untuk JavaScript errors
- Verify semua ID element ada di HTML
- Pastikan fungsi `showCustomAlert()` terpanggil

### Tombol tidak berfungsi
- Check onclick handler di JavaScript
- Verify fungsi `hideCustomAlert()` ada
- Check console untuk errors

### Styling tidak sesuai
- Clear browser cache
- Check Tailwind CSS classes
- Verify CSS file loaded

---

## Summary

**Total Tests:** 15
**Critical Tests:** 8 (Test 1-8)
**Visual Tests:** 3 (Test 9-11)
**Edge Cases:** 4 (Test 12-15)

**Estimasi Waktu Testing:** 30-45 menit

Setelah semua test passed, aplikasi siap untuk automation testing dengan Katalon Studio.
