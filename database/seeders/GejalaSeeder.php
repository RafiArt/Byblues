<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data untuk Orang Terdekat
    FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'OT001',
                'keterangan' => 'Apakah orang terdekat mengetahui jika ibu memiliki riwayat gangguan mental sebelumnya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT002',
                'keterangan' => 'Apakah orang terdekat mengetahui ekspektasi ibu terkait metode persalinan yang diinginkan atau direncanakan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT003',
                'keterangan' => 'Apakah orang terdekat melihat ibu mendapatkan dukungan dari keluarga atau lingkungan selama masa kehamilan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT004',
                'keterangan' => 'Apakah orang terdekat melihat ibu menerima bantuan praktis atau emosional setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT005',
                'keterangan' => 'Apakah orang terdekat memperhatikan adanya dukungan sosial yang diterima ibu sebagai orangtua baru?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT006',
                'keterangan' => 'Apakah orang terdekat sering mendengar ibu mengeluh tentang fisik atau perasaan selama kehamilan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT007',
                'keterangan' => 'Apakah orang terdekat melihat ibu mengeluhkan kondisi fisik atau emosional setelah proses persalinan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT008',
                'keterangan' => 'Apakah orang terdekat memperhatikan ibu sering merasa cemas atau gelisah setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT009',
                'keterangan' => 'Apakah orang terdekat melihat perubahan suasana hati yang tiba-tiba atau drastis pada ibu pasca melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT010',
                'keterangan' => 'Apakah orang terdekat merasa ibu terlihat kelelahan yang tidak wajar, meskipun cukup beristirahat?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT011',
                'keterangan' => 'Apakah orang terdekat melihat ibu sering menangis atau menunjukkan kesedihan tanpa alasan yang jelas?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT012',
                'keterangan' => 'Apakah orang terdekat menyadari bahwa ibu kehilangan minat pada hobi atau aktivitas yang biasa disukai?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT013',
                'keterangan' => 'Apakah orang terdekat melihat ibu kesulitan membangun ikatan emosional dengan bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT014',
                'keterangan' => 'Apakah orang terdekat mendengar ibu mengungkapkan perasaan tidak berharga atau bersalah sebagai seorang ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT015',
                'keterangan' => 'Apakah orang terdekat melihat perubahan nafsu makan ibu yang tidak biasa, seperti makan berlebihan atau kehilangan selera makan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT016',
                'keterangan' => 'Apakah orang terdekat memperhatikan ibu sering merasa kesepian atau terisolasi meskipun dikelilingi keluarga?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'OT017',
                'keterangan' => 'Apakah orang terdekat mengetahui ibu mengalami kesulitan tidur atau gangguan tidur?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT018',
                'keterangan' => 'Apakah orang terdekat menyadari ibu menjadi mudah tersinggung atau cepat marah?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT019',
                'keterangan' => 'Apakah orang terdekat melihat ibu merasa tertekan oleh tanggung jawab sebagai orangtua baru?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT020',
                'keterangan' => 'Apakah orang terdekat merasa ibu sulit untuk meminta atau menerima bantuan dari orang lain?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT021',
                'keterangan' => 'Apakah orang terdekat melihat ibu mengalami kecemasan yang sulit dijelaskan pasca melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT022',
                'keterangan' => 'Apakah orang terdekat melihat ibu menjadi sangat sensitif terhadap kritik atau komentar orang lain?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT023',
                'keterangan' => 'Apakah orang terdekat merasa ibu ragu atau merasa tidak mampu menjalankan peran sebagai ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT024',
                'keterangan' => 'Apakah orang terdekat mengamati ibu kesulitan mengendalikan emosi atau perasaan setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT025',
                'keterangan' => 'Apakah orang terdekat memperhatikan ibu cepat merasa lelah meskipun aktivitas fisik tidak berat?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT026',
                'keterangan' => 'Apakah orang terdekat melihat ibu mulai menarik diri dari interaksi sosial di lingkungan sekitar?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'OT027',
                'keterangan' => 'Apakah orang terdekat memperhatikan adanya perubahan perilaku yang tidak biasa dari ibu atau mengkhawatirkan setelah persalinan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT028',
                'keterangan' => 'Apakah orang terdekat merasa ibu sulit mengekspresikan perasaan atau pikiran secara terbuka?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT029',
                'keterangan' => 'Apakah orang terdekat melihat ibu kurang bersemangat dalam merawat atau berinteraksi dengan bayinya dibanding sebelumnya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT030',
                'keterangan' => 'Apakah orang terdekat mendengar ibu menghindari pembicaraan tentang bayi atau pengalaman kehamilan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT031',
                'keterangan' => 'Apakah orang terdekat melihat ibu menjadi lebih gugup atau cemas saat bertemu banyak orang atau di acara sosial?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'OT032',
                'keterangan' => 'Apakah orang terdekat mengamati ibu lebih mudah menangis saat menghadapi situasi sehari-hari yang kecil?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT033',
                'keterangan' => 'Apakah orang terdekat memperhatikan ibu mengalami kesulitan berkonsentrasi atau sering lupa setelah melahirkan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT034',
                'keterangan' => 'Apakah orang terdekat mendengar ibu mengeluh tentang rasa sakit atau ketidaknyamanan fisik yang berkepanjangan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT035',
                'keterangan' => 'Apakah orang terdekat melihat ibu kesulitan mengambil keputusan sederhana sehari-hari?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT036',
                'keterangan' => 'Apakah orang terdekat merasa ibu menjadi lebih cepat marah atau sensitif dibanding sebelumnya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT037',
                'keterangan' => 'Apakah orang terdekat mengamati ibu tampak kurang puas atau khawatir berlebihan dengan cara merawat bayinya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT038',
                'keterangan' => 'Apakah orang terdekat memperhatikan ibu merasa cemas berlebihan terkait keselamatan atau kesehatan bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT039',
                'keterangan' => 'Apakah orang terdekat sering melihat ibu merasa kesepian walaupun ada orang di sekitarnya?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'OT040',
                'keterangan' => 'Apakah orang terdekat melihat ibu mengalami kesulitan menyeimbangkan kebutuhan dirinya dan bayi?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
        ]);


        // Data untuk Suami
        FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'SU001',
                'keterangan' => 'Apakah Anda saat ini memiliki pekerjaan tetap?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU002',
                'keterangan' => 'Apakah jarak tempat kerja Anda cukup menyulitkan untuk sering pulang tepat waktu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU003',
                'keterangan' => 'Apakah Anda merasa percaya diri saat merawat bayi secara mandiri?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU004',
                'keterangan' => 'Apakah anda sering berinisiatif menggantikan istri dalam mengasuh bayi, tanpa diminta?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU005',
                'keterangan' => 'Pernahkah Anda merasa bingung menghadapi perubahan emosional istri setelah melahirkan?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU006',
                'keterangan' => 'Apakah Anda merasa tahu cara yang paling tepat untuk menenangkan istri saat ia stres?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU007',
                'keterangan' => 'Apakah Anda pernah mendampingi istri menjalani pemeriksaan rutin kehamilan dan berbicara dengan tenaga medis?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU008',
                'keterangan' => 'Apakah Anda merasa istri Anda sering menghindari kontak fisik atau pembicaraan mendalam?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU009',
                'keterangan' => 'Menurut Anda, apakah Anda cukup bisa mendengarkan keluh kesah istri dengan empati?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU010',
                'keterangan' => 'Apakah Anda merasa memiliki hubungan emosional yang hangat dengan istri?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU011',
                'keterangan' => 'Pernahkah Anda merasa seperti "orang asing" di rumah sendiri setelah kelahiran anak?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU012',
                'keterangan' => 'Apakah Anda tetap berusaha menjaga komunikasi intens dengan istri setelah kelahiran anak?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU013',
                'keterangan' => 'Apakah Anda merasa menjadi sosok yang dibutuhkan secara emosional oleh istri selama masa adaptasi ini?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU014',
                'keterangan' => 'Apakah Anda menyadari perubahan suasana hati istri yang terjadi secara tiba-tiba atau tidak terduga?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU015',
                'keterangan' => 'Selama kehamilan istri, apakah Anda merasa telah memberikan dukungan yang konsisten secara emosional dan praktis?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU016',
                'keterangan' => 'Apakah Anda menemani istri selama proses kelahiran anak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU017',
                'keterangan' => 'Apakah Anda memperhatikan asupan gizi istri selama dan setelah kehamilan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU018',
                'keterangan' => 'Apakah Anda dan istri sempat mencari pengetahuan seputar pengasuhan sebelum anak lahir?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU019',
                'keterangan' => 'Apakah istri Anda sempat berolahraga ringan secara rutin selama masa kehamilan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU020',
                'keterangan' => 'Setelah persalinan, apakah Anda merasa cukup aktif membantu istri dalam mengurus bayi?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU021',
                'keterangan' => 'Apakah Anda meluangkan waktu secara rutin untuk menjaga kualitas waktu bersama anak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU022',
                'keterangan' => 'Apakah Anda memberikan ruang bagi istri untuk memiliki waktu pribadi (me-time)?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU023',
                'keterangan' => 'Apakah Anda bersedia menjalankan tugas perawatan bayi seperti menyusui dengan botol, mengganti popok, atau menidurkan anak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU024',
                'keterangan' => 'Apakah pola tidur Anda dan istri terganggu sejak kelahiran anak?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU025',
                'keterangan' => 'Apakah Anda memperhatikan bahwa istri mudah tersinggung atau marah tanpa sebab yang jelas?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU026',
                'keterangan' => 'Apakah istri pernah mengalami gangguan psikologis sebelumnya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU027',
                'keterangan' => 'Apakah istri Anda sering merasa tidak dimengerti meskipun Anda berusaha memberikan dukungan?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU028',
                'keterangan' => 'Apakah istri Anda terlihat mudah merasa cemas terhadap hal-hal kecil setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU029',
                'keterangan' => 'Apakah istri Anda pernah menyebut bahwa hidupnya terasa tidak berarti atau hampa?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU030',
                'keterangan' => 'Apakah istri Anda sering terlihat lelah secara berlebihan meski aktivitasnya tidak terlalu berat?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU031',
                'keterangan' => 'Saat bayi tidur, apakah istri kesulitan beristirahat atau tetap merasa gelisah?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU032',
                'keterangan' => 'Apakah Anda memperhatikan bahwa istri kehilangan minat pada aktivitas yang dulu disukai?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU033',
                'keterangan' => 'Apakah istri Anda pernah menangis tanpa alasan yang jelas setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU034',
                'keterangan' => 'Apakah istri Anda menjadi lebih peka terhadap kritik dari orang lain atau bahkan Anda sendiri?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU035',
                'keterangan' => 'Apakah istri Anda pernah menyampaikan keraguan terhadap kemampuannya sebagai seorang ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU036',
                'keterangan' => 'Apakah istri Anda pernah mengungkapkan perasaan tidak mampu menjalani peran barunya sebagai ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU037',
                'keterangan' => 'Apakah istri pernah berkata bahwa ia merasa tidak cukup baik sebagai ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU038',
                'keterangan' => 'Apakah istri Anda sering membandingkan dirinya dengan ibu lain dan merasa kalah atau gagal?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU039',
                'keterangan' => 'Apakah istri Anda pernah menyatakan penyesalan atau harapan agar dirinya belum memiliki anak sekarang?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU040',
                'keterangan' => 'Apakah ada orang lain (keluarga/kerabat) yang aktif mendukung proses adaptasi istri menjadi ibu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
        ]);

        // Data untuk Ibu
        FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'IB001',
                'keterangan' => 'Apakah kehamilan terjadi karena kemauan ibu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB002',
                'keterangan' => 'Apakah ibu pernah menjalani proses kehamilan sebelumnya?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB003',
                'keterangan' => 'Apakah ibu bekerja?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB004',
                'keterangan' => 'Apakah lokasi kerja ibu jauh dengan tempat tinggal?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB005',
                'keterangan' => 'Apakah ibu ingin menjadi seorang ibu rumah tangga?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB006',
                'keterangan' => 'Apakah ada konflik dalam pernikahan ibu?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB007',
                'keterangan' => 'Apakah suami mendampingi ibu selama kehamilan, baik secara fisik atau emosional?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB008',
                'keterangan' => 'Apakah kondisi finansial ibu dan keluarga kurang untuk mendukung kehamilan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB009',
                'keterangan' => 'Apakah ibu kurang tidur dalam satu hari?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB010',
                'keterangan' => 'Apakah nutrisi ibu selama kehamilan sudah cukup dan lengkap?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB011',
                'keterangan' => 'Apakah ibu memiliki impian tentang proses melahirkan, seperti memilih metode caesar atau normal?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB012',
                'keterangan' => 'Apakah ibu merasakan tekanan selama kehamilan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB013',
                'keterangan' => 'Apakah hubungan ibu dengan orang tua kandungnya baik?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB014',
                'keterangan' => 'Apakah hubungan ibu dengan mertua baik?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB015',
                'keterangan' => 'Apakah Ibu merasa lebih mudah atau lebih nyaman berbicara dengan teman (sahabat) daripada dengan keluarga (suami, orang tua, mertua)?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB016',
                'keterangan' => 'Apakah ibu mendapat dukungan dari orang tua kandung dan mertua selama kehamilan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB017',
                'keterangan' => 'Apakah suami memiliki ekspektasi terhadap metode melahirkan yang akan dijalani ibu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB018',
                'keterangan' => 'Apakah orang tua atau mertua memiliki ekspektasi terkait metode melahirkan ibu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB019',
                'keterangan' => 'Apakah ibu memiliki waktu yang cukup untuk berolahraga selama kehamilan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB020',
                'keterangan' => 'Apakah ibu merasa nyaman dengan perubahan bentuk tubuh selama kehamilan dan setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB021',
                'keterangan' => 'Apakah ibu pernah merasa ingin menjauh dari bayi atau merasa tidak nyaman dengan bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB022',
                'keterangan' => 'Apakah suami mendampingi ibu saat melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB023',
                'keterangan' => 'Apakah orang tua atau mertua mendampingi ibu saat melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB024',
                'keterangan' => 'Apakah ibu merasa bahagia saat melihat bayi yang baru dilahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB025',
                'keterangan' => 'Apakah ibu menerima bantuan dalam merawat bayi setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB026',
                'keterangan' => 'Apakah ibu memiliki waktu untuk dirinya sendiri (me-time) setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB027',
                'keterangan' => 'Apakah ibu merasa kesepian meskipun ada orang di sekitar?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB028',
                'keterangan' => 'Apakah ibu merasa bersalah atau merasa dirinya tidak mampu menjadi ibu yang baik?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB029',
                'keterangan' => 'Apakah proses pemberian ASI berjalan lancar?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB030',
                'keterangan' => 'Apakah ibu merasa sulit mengendalikan emosi seperti mudah marah, gelisah, atau cemas secara berlebihan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB031',
                'keterangan' => 'Apakah suami membantu ibu dalam proses pengasuhan bayi setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB032',
                'keterangan' => 'Apakah waktu pengasuhan bayi dibagi antara ibu dan suami?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB033',
                'keterangan' => 'Apakah ibu tidur cukup setelah melahirkan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB034',
                'keterangan' => 'Apakah ibu pernah berbicara dengan suami mengenai proses adaptasi setelah melahirkan?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB035',
                'keterangan' => 'Apakah jadwal makan ibu berantakan setelah melahirkan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB036',
                'keterangan' => 'Apakah ibu merasa kesulitan menjalani peran sebagai orang tua baru?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB037',
                'keterangan' => 'Apakah ibu mengalami perubahan suasana hati setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB038',
                'keterangan' => 'Apakah ibu merasa kewalahan menjalani peran sebagai orang tua baru?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB039',
                'keterangan' => 'Apakah ibu cemas tentang kondisi kesehatan dan keselamatan bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB040',
                'keterangan' => 'Apakah ibu sering merasa sedih atau ingin menangis setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
        ]);
    }
}
