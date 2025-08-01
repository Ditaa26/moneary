# Aplikasi Moneary (Catatan Keuangan)  
Moneary adalah aplikasi catatan keuangan digital bertema pink yang dirancang untuk membantu kamu mencatat pemasukan, pengeluaran, dan target tabungan dengan mudah dan estetik. Cocok untuk kamu yang ingin mengelola keuangan harian secara praktis!  
### Latar Belakang  
Literasi keuangan merupakan kemampuan penting yang masih rendah di kalangan remaja dan mahasiswa. Kurangnya pemahaman dalam mengelola keuangan membuat generasi muda rentan terhadap perilaku konsumtif, utang daring, dan kesulitan menabung.
Pemanfaatan teknologi digital melalui aplikasi keuangan dinilai efektif dalam meningkatkan pemahaman dan perilaku finansial yang sehat. Namun, banyak aplikasi keuangan yang ada saat ini masih dianggap kompleks dan kurang menarik bagi anak muda.
Untuk itu, dikembangkan Moneary, aplikasi pencatatan keuangan digital bertema pink yang dirancang khusus untuk remaja dan mahasiswa. Dengan tampilan yang visual, ringan, dan menyenangkan, Moneary tidak hanya membantu mencatat keuangan, tapi juga mendorong gaya hidup finansial yang sehat, praktis, dan sesuai dengan karakteristik generasi muda masa kini.
### Tujuan  
1. Meningkatkan Literasi Keuangan Remaja dan Mahasiswa Melalui Media Digital.
2. Menyediakan Aplikasi Pencatatan Keuangan yang Kreatif, Interaktif, dan Mudah Digunakan.
3. Memfasilitasi Perencanaan dan Pemantauan Keuangan Harian dan Bulanan Secara Mandiri.
### Deksripsi Sistem  
Sistem yang telah dikembangkan dalam aplikasi Moneary merupakan sebuah aplikasi 
pencatatan keuangan pribadi yang berfokus pada kemudahan penggunaan, tampilan 
yang estetis, dan fungsionalitas dasar yang sesuai dengan kebutuhan remaja serta 
mahasiswa. Aplikasi ini memiliki beberapa komponen utama yang membentuk alur 
kerja sistem secara menyeluruh. 
Pertama, pengguna akan disambut dengan **Halaman SplashScreen**, yaitu tampilan 
pembuka yang muncul saat aplikasi pertama kali dijalankan. Halaman ini dirancang 
untuk memberikan kesan awal yang menarik melalui visual sederhana, logo aplikasi, 
dan slogan “Simpan dan catat uangmu!” yang mencerminkan tujuan utama aplikasi. 
Tersedia tombol “Mulai” yang akan mengarahkan pengguna menuju halaman login. 
Setelah itu, pengguna akan masuk ke **Halaman Login**, yang merupakan gerbang utama 
untuk mengakses sistem. Pada halaman ini, tersedia form autentikasi berupa input email 
dan password. Jika pengguna memasukkan kredensial yang benar, sistem akan 
mengarahkan ke halaman utama aplikasi. Namun, jika informasi tidak sesuai, sistem 
akan memberikan peringatan kesalahan. Untuk pengguna baru, disediakan tautan ke 
halaman pendaftaran (Sign Up) di bagian bawah, sehingga mereka dapat membuat akun 
terlebih dahulu sebelum masuk ke sistem. 
**Halaman Sign Up** digunakan untuk proses registrasi pengguna baru. Formulir pada 
halaman ini mencakup tiga input utama, yaitu email, nama, dan password. Setelah 
pengguna mengisi seluruh data dengan benar dan menekan tombol "Daftar", sistem 
akan melakukan validasi dan menyimpan data ke dalam basis data lokal apabila data 
dinyatakan valid. Setelah itu, pengguna akan diarahkan kembali ke halaman login untuk 
melakukan autentikasi menggunakan akun yang baru dibuat.  
Setelah berhasil melakukan login, pengguna akan diarahkan ke **Halaman Utama**. 
Halaman ini berfungsi sebagai pusat informasi keuangan pengguna. Di sini, pengguna 
dapat melihat ringkasan keuangan berupa total saldo, jumlah pemasukan, dan jumlah 
pengeluaran. Selain itu, ditampilkan pula daftar nama catatan yang telah dibuat 
sebelumnya. Pengguna bisa memilih nama catatan yang mau ditampilkan di halaman 
utama. Antarmuka halaman utama dirancang agar informatif namun tetap simpel, 
sehingga pengguna dapat langsung memahami kondisi keuangannya secara cepat. 
Tersedia tombol navigasi menuju halaman Buku untuk melihat catatan lebih rinci, 
tombol tambah "+" untuk mencatat transaksi baru. 
Selanjutnya, terdapat **Halaman Profil**, yang berfungsi untuk menampilkan data 
pengguna seperti nama, email, dan password (biasanya ditampilkan dalam bentuk 
tersembunyi atau readonly). Pada halaman ini, pengguna dapat melakukan dua tindakan 
utama, yaitu kembali ke halaman utama atau melakukan logout dari aplikasi. Jika 
pengguna memilih logout, maka sistem akan menghapus sesi dan langsung 
mengarahkan pengguna kembali ke halaman login untuk keamanan. 
**Halaman Buku** menyajikan daftar catatan transaksi yang telah dibuat pengguna dalam 
format daftar vertikal dengan dukungan scrolling. Setiap item catatan dapat ditekan 
untuk membuka detail transaksi yang lebih lengkap. Tujuan dari halaman ini adalah 
memberi pengguna kendali dan akses cepat ke seluruh catatan yang telah mereka buat. 
Tersedia juga tombol untuk kembali ke halaman utama agar navigasi tetap praktis. 
Untuk membuat catatan transaksi baru, pengguna diarahkan ke **Halaman Buat 
Catatan Buku**. Pada halaman ini, tersedia form input lengkap yang mencakup nama 
catatan, tanggal transaksi, jenis transaksi (pemasukan atau pengeluaran), target 
keuangan, jumlah nominal, dan keterangan tambahan. Sistem akan melakukan validasi 
atas seluruh input tersebut sebelum menyimpannya ke basis data lokal. Jika data valid, 
maka transaksi akan disimpan dan pengguna akan langsung diarahkan ke halaman 
detail dari catatan yang baru saja dibuat. 
**Halaman Detail Catatan Buku** memberikan tampilan menyeluruh terhadap catatan 
tertentu. Di sini, pengguna dapat melihat rincian seperti total pemasukan, pengeluaran, 
saldo yang tersisa, serta target keuangan yang telah ditetapkan. Terdapat juga 
visualisasi berupa progress bar yang menunjukkan sejauh mana target keuangan 
tercapai lengkap dengan fitur edit dan hapus Di bagian bawah halaman ditampilkan 
riwayat transaksi dalam bentuk tabel. Pengguna juga dapat menghapus satu catatan 
tertentu, di mana sistem akan menampilkan pesan konfirmasi terlebih dahulu sebelum 
menghapus data tersebut secara permanen. Ketika sebuah catatan dihapus, seluruh 
transaksi yang terkait dengan catatan tersebut juga akan ikut terhapus secara otomatis. 
Hal ini untuk menjaga konsistensi data dan menghindari transaksi yang terisolasi tanpa 
referensi. Selain itu, disediakan pula tombol untuk kembali ke halaman Buku guna 
memudahkan navigasi pengguna setelah melakukan aksi penghapusan. 
Untuk melakukan perubahan pada transaksi yang sudah ada, tersedia **Halaman Edit 
Catatan Buku**. Di sini, pengguna dapat memperbarui detail transaksi tertentu, seperti 
tanggal, nominal, dan keterangan. Namun, beberapa kolom seperti nama catatan dan 
target keuangan dikunci agar tidak dapat diedit. Setelah perubahan disimpan, sistem 
akan memperbarui data di basis data serta menyesuaikan perhitungan saldo dan progres 
secara otomatis. Riwayat transaksi tetap ditata berdasarkan urutan kronologis agar 
memudahkan pelacakan. 
Dengan struktur sistem seperti ini, aplikasi Moneary telah mampu menyediakan alur 
penggunaan yang utuh dan terorganisir, mulai dari masuk ke sistem, mencatat 
keuangan, hingga mengelola detail transaksi secara efisien. Meskipun masih bersifat 
lokal dan sederhana, sistem yang ada sudah cukup representatif sebagai fondasi aplikasi 
literasi keuangan yang ringan dan edukatif bagi pengguna muda. 

**Link Figma** : https://www.figma.com/design/IJz74K1PIs5ZnU6mbQEyjG/Moneary?node-id=4183-178&t=qV44PMla1w2KISlh-1 




