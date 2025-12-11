# Panduan Custom Popup untuk Katalon Testing

## Ringkasan Perubahan

Semua `alert()` dan `confirm()` dialog di bagian "Tambah Kegiatan" telah diganti dengan custom popup modal yang dapat di-capture oleh Katalon Studio untuk automation testing.

## Struktur Custom Popup

### HTML Elements dengan ID untuk Katalon

```html
<div id="customAlertModal">          <!-- Modal Container -->
  <div id="alertIcon">               <!-- Icon Container -->
  <h3 id="alertTitle">               <!-- Title Text -->
  <p id="alertMessage">              <!-- Message Text -->
  <button id="alertOkBtn">           <!-- OK Button -->
  <button id="alertCancelBtn">       <!-- Cancel Button (untuk confirm) -->
</div>
```

## Tipe Popup

### 1. Success Popup (Hijau)
- **Digunakan untuk**: Operasi berhasil
- **Warna**: Hijau (#10B981)
- **Icon**: Checkmark
- **Contoh**: "Kegiatan berhasil dihapus"

### 2. Error Popup (Merah)
- **Digunakan untuk**: Error/Gagal
- **Warna**: Merah (#EF4444)
- **Icon**: X Mark
- **Contoh**: "Gagal memuat detail kegiatan"

### 3. Confirmation Popup (Orange)
- **Digunakan untuk**: Konfirmasi aksi
- **Warna**: Orange (#F97316)
- **Icon**: Warning Triangle
- **Tombol**: OK dan Batal
- **Contoh**: "Apakah Anda yakin ingin menghapus kegiatan ini?"

## Daftar Perubahan Alert

### Alert yang Diganti:

1. ✅ `alert('Gagal memuat detail kegiatan')` 
   → `showCustomAlert('Gagal memuat detail kegiatan', 'error')`

2. ✅ `alert('Gagal memuat data kegiatan')` 
   → `showCustomAlert('Gagal memuat data kegiatan', 'error')`

3. ✅ `alert('Kegiatan berhasil dihapus')` 
   → `showCustomAlert('Kegiatan berhasil dihapus', 'success')`

4. ✅ `alert('Gagal menghapus kegiatan')` 
   → `showCustomAlert('Gagal menghapus kegiatan', 'error')`

5. ✅ `alert(data.message)` 
   → `showCustomAlert(data.message, 'success')`

6. ✅ `alert('Error: ' + ...)` 
   → `showCustomAlert('Error: ' + ..., 'error')`

7. ✅ `alert('Gagal menyimpan kegiatan: ' + error.message)` 
   → `showCustomAlert('Gagal menyimpan kegiatan: ' + error.message, 'error')`

### Confirm yang Diganti:

1. ✅ `confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')` 
   → `showCustomAlert('Apakah Anda yakin ingin menghapus kegiatan ini?', 'confirm', callback)`

## Cara Menggunakan di Katalon Studio

### 1. Menangkap Popup Modal

```groovy
// Wait for popup to appear
WebUI.waitForElementVisible(findTestObject('Object Repository/Popup/customAlertModal'), 10)

// Verify popup is displayed
WebUI.verifyElementVisible(findTestObject('Object Repository/Popup/customAlertModal'))
```

### 2. Membaca Pesan Popup

```groovy
// Get alert title
String title = WebUI.getText(findTestObject('Object Repository/Popup/alertTitle'))

// Get alert message
String message = WebUI.getText(findTestObject('Object Repository/Popup/alertMessage'))

// Verify message
WebUI.verifyMatch(message, 'Kegiatan berhasil dihapus', false)
```

### 3. Klik Tombol OK

```groovy
// Click OK button
WebUI.click(findTestObject('Object Repository/Popup/alertOkBtn'))

// Wait for popup to disappear
WebUI.waitForElementNotVisible(findTestObject('Object Repository/Popup/customAlertModal'), 5)
```

### 4. Klik Tombol Batal (untuk Confirmation)

```groovy
// Click Cancel button
WebUI.click(findTestObject('Object Repository/Popup/alertCancelBtn'))
```

### 5. Verifikasi Tipe Popup

```groovy
// Verify success popup (green)
WebUI.verifyElementPresent(findTestObject('Object Repository/Popup/alertOkBtn'), 5)
String okBtnClass = WebUI.getAttribute(findTestObject('Object Repository/Popup/alertOkBtn'), 'class')
WebUI.verifyMatch(okBtnClass, '.*bg-green-500.*', true)

// Verify error popup (red)
WebUI.verifyMatch(okBtnClass, '.*bg-red-500.*', true)

// Verify confirmation popup (orange with cancel button)
WebUI.verifyElementVisible(findTestObject('Object Repository/Popup/alertCancelBtn'))
WebUI.verifyMatch(okBtnClass, '.*bg-orange-500.*', true)
```

## Test Object Definitions untuk Katalon

### Custom Alert Popup Elements

#### customAlertModal
- **Selector Type**: CSS
- **Selector Value**: `#customAlertModal`
- **Description**: Main popup modal container

#### alertTitle
- **Selector Type**: CSS
- **Selector Value**: `#alertTitle`
- **Description**: Popup title text

#### alertMessage
- **Selector Type**: CSS
- **Selector Value**: `#alertMessage`
- **Description**: Popup message text

#### alertOkBtn
- **Selector Type**: CSS
- **Selector Value**: `#alertOkBtn`
- **Description**: OK button

#### alertCancelBtn
- **Selector Type**: CSS
- **Selector Value**: `#alertCancelBtn`
- **Description**: Cancel button (only visible in confirmation popup)

#### alertIcon
- **Selector Type**: CSS
- **Selector Value**: `#alertIcon`
- **Description**: Icon container

### Modal Detail Kegiatan Elements

#### btnTutupDetail
- **Selector Type**: CSS
- **Selector Value**: `#btnTutupDetail`
- **Description**: Tombol Tutup di modal detail kegiatan

#### btnEditKegiatan
- **Selector Type**: CSS
- **Selector Value**: `#btnEditKegiatan`
- **Description**: Tombol Edit di modal detail kegiatan

#### btnHapusKegiatan
- **Selector Type**: CSS
- **Selector Value**: `#btnHapusKegiatan`
- **Description**: Tombol Hapus di modal detail kegiatan

## Contoh Test Case Lengkap

### Test Case: Tambah Kegiatan Berhasil

```groovy
// 1. Login sebagai admin
WebUI.openBrowser('http://localhost:8000')
WebUI.setText(findTestObject('Login/username'), 'admin')
WebUI.setText(findTestObject('Login/password'), 'password')
WebUI.click(findTestObject('Login/loginBtn'))

// 2. Klik tombol Tambah Kegiatan
WebUI.click(findTestObject('Dashboard/btnTambahKegiatan'))

// 3. Isi form
WebUI.setText(findTestObject('Form/nama_kegiatan'), 'Test Kegiatan')
WebUI.setText(findTestObject('Form/tanggal_kegiatan'), '2025-12-31')
WebUI.setText(findTestObject('Form/waktu_mulai'), '09:00')
WebUI.setText(findTestObject('Form/waktu_selesai'), '12:00')
WebUI.setText(findTestObject('Form/tempat'), 'Aula Kampus')

// 4. Submit form
WebUI.click(findTestObject('Form/btnSimpan'))

// 5. Verify success popup appears
WebUI.waitForElementVisible(findTestObject('Popup/customAlertModal'), 10)
WebUI.verifyElementVisible(findTestObject('Popup/alertTitle'))
WebUI.verifyElementVisible(findTestObject('Popup/alertMessage'))

// 6. Verify popup type is success (green)
String okBtnClass = WebUI.getAttribute(findTestObject('Popup/alertOkBtn'), 'class')
WebUI.verifyMatch(okBtnClass, '.*bg-green-500.*', true)

// 7. Read and verify message
String message = WebUI.getText(findTestObject('Popup/alertMessage'))
WebUI.verifyMatch(message, '.*berhasil.*', true)

// 8. Click OK
WebUI.click(findTestObject('Popup/alertOkBtn'))

// 9. Wait for page reload
WebUI.delay(2)
```

### Test Case: Hapus Kegiatan dengan Konfirmasi

```groovy
// 1. Click kegiatan di kalender
WebUI.click(findTestObject('Calendar/eventItem'))

// 2. Wait for detail modal
WebUI.waitForElementVisible(findTestObject('Modal/detailModal'), 5)

// 3. Verify tombol-tombol di modal detail terlihat
WebUI.verifyElementVisible(findTestObject('Modal/btnTutupDetail'))
WebUI.verifyElementVisible(findTestObject('Modal/btnEditKegiatan'))
WebUI.verifyElementVisible(findTestObject('Modal/btnHapusKegiatan'))

// 4. Click tombol Hapus menggunakan ID
WebUI.click(findTestObject('Modal/btnHapusKegiatan'))

// 5. Verify confirmation popup appears
WebUI.waitForElementVisible(findTestObject('Popup/customAlertModal'), 5)
WebUI.verifyElementVisible(findTestObject('Popup/alertCancelBtn'))

// 6. Verify popup type is confirmation (orange)
String okBtnClass = WebUI.getAttribute(findTestObject('Popup/alertOkBtn'), 'class')
WebUI.verifyMatch(okBtnClass, '.*bg-orange-500.*', true)

// 7. Read confirmation message
String message = WebUI.getText(findTestObject('Popup/alertMessage'))
WebUI.verifyMatch(message, '.*yakin.*hapus.*', true)

// 8. Click OK to confirm
WebUI.click(findTestObject('Popup/alertOkBtn'))

// 9. Verify success popup appears
WebUI.waitForElementVisible(findTestObject('Popup/customAlertModal'), 5)
String successMessage = WebUI.getText(findTestObject('Popup/alertMessage'))
WebUI.verifyMatch(successMessage, '.*berhasil dihapus.*', true)

// 10. Click OK
WebUI.click(findTestObject('Popup/alertOkBtn'))

// 11. Wait for page reload
WebUI.delay(2)
```

### Test Case: Edit Kegiatan dari Modal Detail

```groovy
// 1. Click kegiatan di kalender
WebUI.click(findTestObject('Calendar/eventItem'))

// 2. Wait for detail modal
WebUI.waitForElementVisible(findTestObject('Modal/detailModal'), 5)

// 3. Verify detail kegiatan ditampilkan
WebUI.verifyElementVisible(findTestObject('Modal/detailTitle'))
WebUI.verifyElementVisible(findTestObject('Modal/detailJadwal'))
WebUI.verifyElementVisible(findTestObject('Modal/detailKegiatan'))
WebUI.verifyElementVisible(findTestObject('Modal/detailTempat'))

// 4. Click tombol Edit menggunakan ID
WebUI.click(findTestObject('Modal/btnEditKegiatan'))

// 5. Verify form edit muncul (modal add/edit)
WebUI.waitForElementVisible(findTestObject('Modal/addModal'), 5)

// 6. Verify form sudah terisi dengan data kegiatan
WebUI.verifyElementPresent(findTestObject('Form/kegiatan_id'), 5)
String kegiatanId = WebUI.getAttribute(findTestObject('Form/kegiatan_id'), 'value')
WebUI.verifyNotEqual(kegiatanId, '')

// 7. Edit data kegiatan
WebUI.clearText(findTestObject('Form/nama_kegiatan'))
WebUI.setText(findTestObject('Form/nama_kegiatan'), 'Kegiatan Updated')

// 8. Submit form
WebUI.click(findTestObject('Form/btnSimpan'))

// 9. Verify success popup
WebUI.waitForElementVisible(findTestObject('Popup/customAlertModal'), 10)
String message = WebUI.getText(findTestObject('Popup/alertMessage'))
WebUI.verifyMatch(message, '.*berhasil.*', true)

// 10. Click OK
WebUI.click(findTestObject('Popup/alertOkBtn'))

// 11. Wait for page reload
WebUI.delay(2)
```

### Test Case: Tutup Modal Detail Kegiatan

```groovy
// 1. Click kegiatan di kalender
WebUI.click(findTestObject('Calendar/eventItem'))

// 2. Wait for detail modal
WebUI.waitForElementVisible(findTestObject('Modal/detailModal'), 5)

// 3. Verify modal detail terlihat
WebUI.verifyElementVisible(findTestObject('Modal/detailTitle'))

// 4. Click tombol Tutup menggunakan ID
WebUI.click(findTestObject('Modal/btnTutupDetail'))

// 5. Verify modal detail tertutup
WebUI.waitForElementNotVisible(findTestObject('Modal/detailModal'), 5)
WebUI.verifyElementNotVisible(findTestObject('Modal/detailModal'))
```

## Keuntungan Custom Popup

1. ✅ **Dapat di-capture oleh Katalon** - Semua element memiliki ID unik
2. ✅ **Konsisten** - Tampilan dan behavior yang sama di semua browser
3. ✅ **Testable** - Dapat diverifikasi tipe, pesan, dan tombol
4. ✅ **User-friendly** - Tampilan lebih menarik dengan icon dan warna
5. ✅ **Flexible** - Mudah dikustomisasi untuk kebutuhan testing

## Troubleshooting

### Popup tidak muncul
- Pastikan JavaScript tidak error (check console)
- Verify element ID sudah benar
- Tunggu dengan `WebUI.waitForElementVisible()`

### Tombol Cancel tidak terlihat
- Tombol Cancel hanya muncul untuk tipe 'confirm'
- Untuk success/error, hanya tombol OK yang muncul

### Popup tidak hilang setelah klik OK
- Pastikan fungsi `hideCustomAlert()` dipanggil
- Check apakah ada error di callback function

## File yang Dimodifikasi

- `resources/views/dashboard.blade.php` - File utama yang diubah

## Tanggal Update

Terakhir diupdate: 2025-01-XX
