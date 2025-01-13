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
        // Data untuk Orang Tua
        FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'OT001',
                'keterangan' => 'Apakah anak memiliki riwayat penyakit mental?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT002',
                'keterangan' => 'Apakah orangtua memiliki ekspektasi terhadap metode melahirkan yang akan ibu lalui?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT003',
                'keterangan' => 'Apakah orangtua membantu anak pada saat menjalani proses kehamilan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT004',
                'keterangan' => 'Apakah orangtua membantu anak setelah anak menjalani proses persalinan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT005',
                'keterangan' => 'Apakah orangtua memberikan support terhadap anak setelah anak menjadi orangtua baru?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT006',
                'keterangan' => 'Apakah anak sering berkeluh kesah mengenai kondisinya selama proses kehamilan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT007',
                'keterangan' => 'Apakah anak sering berkeluh kesah mengenai kondisinya setelah proses persalinan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT008',
                'keterangan' => 'Apakah anak sering merasa cemas atau khawatir setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT009',
                'keterangan' => 'Apakah anak mengalami perubahan suasana hati yang drastis setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT010',
                'keterangan' => 'Apakah anak merasa sangat lelah meskipun sudah cukup istirahat?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT011',
                'keterangan' => 'Apakah anak sering merasa sedih atau menangis tanpa alasan yang jelas?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT012',
                'keterangan' => 'Apakah anak kehilangan minat pada aktivitas yang biasanya disukai?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT013',
                'keterangan' => 'Apakah anak merasa kesulitan untuk terhubung dengan bayinya?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT014',
                'keterangan' => 'Apakah anak merasa tidak berharga atau merasa bersalah sebagai ibu?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT015',
                'keterangan' => 'Apakah anak mengalami perubahan nafsu makan, seperti makan terlalu banyak atau kehilangan selera makan?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT016',
                'keterangan' => 'Apakah anak merasa terisolasi atau kesepian meskipun ada dukungan dari keluarga?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'OT017',
                'keterangan' => 'Apakah anak mengeluh tentang kesulitan tidur atau insomnia?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'OT018',
                'keterangan' => 'Apakah anak sering merasa mudah marah atau tersinggung?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'OT019',
                'keterangan' => 'Apakah anak merasa tertekan dengan tanggung jawab baru sebagai ibu?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'OT020',
                'keterangan' => 'Apakah anak merasa sulit untuk meminta bantuan atau dukungan dari orang lain?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
        ]);

        // Data untuk Suami
        FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'SU001',
                'keterangan' => 'Apakah suami bekerja?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU002',
                'keterangan' => 'Lokasi suami bekerja apakah jauh?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU003',
                'keterangan' => 'Apakah suami rutin berkomunikasi dengan istri?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU004',
                'keterangan' => 'Apakah suami memiliki kedekatan emosional dengan istri?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU005',
                'keterangan' => 'Apakah suami memberikan pelayanan yang baik selama istri hamil?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU006',
                'keterangan' => 'Bagaimana kondisi finansial keluarga?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU007',
                'keterangan' => 'Apakah kebutuhan rumah tangga tercukupi?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU008',
                'keterangan' => 'Apakah saat bersama istri suami terlibat dalam pengasuhan anak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU009',
                'keterangan' => 'Apakah suami termasuk seorang gamers?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU010',
                'keterangan' => 'Apakah suami dan istri memiliki waktu untuk berekreasi dalam kurun waktu tertentu?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU011',
                'keterangan' => 'Apakah selama kehamilan istri memilki waktu untuk berolahraga?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU012',
                'keterangan' => 'Apakah istri memiliki riwayat penyakit mental?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU013',
                'keterangan' => 'Apakah suami menemani istri saat proses persalinan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU014',
                'keterangan' => 'Apakah suami membantu istri selama proses persalinan dan setelah proses persalinan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU015',
                'keterangan' => 'Apakah terdapat konflik dalam pernikahan?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU016',
                'keterangan' => 'Apakah suami memilki ekspektasi ibu akan memberikan bayi asi eksklusif atau tidak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU017',
                'keterangan' => 'Apakah suami mencukupi kebutuhan nutrisi istri?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU018',
                'keterangan' => 'Apakah suami terlibat dalam proses adaptasi istri setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU019',
                'keterangan' => 'Apakah suami memiliki waktu untuk mengurus bayi?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU020',
                'keterangan' => 'Apakah suami memberikan istri untuk memilki me-time?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU021',
                'keterangan' => 'Bagaimana jam tidur suami dan istri?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'SU022',
                'keterangan' => 'Apakah istri sering marah2 tanpa alasan setelah menjadi orangtua baru?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU023',
                'keterangan' => 'Apakah suami berkomunikasi secara intens dengan istri setelah istri melahirkan?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'SU024',
                'keterangan' => 'Apakah suami menjadi support system yang baik untuk istri?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU025',
                'keterangan' => 'Apakah istri memilki bantuan dalam kehidupan sehari2 setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU026',
                'keterangan' => 'Apakah suami memilki kelekatan secara emosional dengan istri dan anak?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'SU027',
                'keterangan' => 'Apakah suami mau melaksanakan tugas merawat bayi seperti yang dilakukan oleh istri?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'SU028',
                'keterangan' => 'Apakah suami dan istri sebelum menjadi orangtua menyempatkan waktu untuk menambah ilmu mengenai pengasuhan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
        ]);

        // Data untuk Ibu
        FacadesDB::table('gejalas')->insert([
            [
                'kode' => 'IB001',
                'keterangan' => 'Apakah kehamilan terjadi karena kemauan ibu atau tidak?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB002',
                'keterangan' => 'Bagaimana proses kehamilan yang telah dilalui oleh ibu?',
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
                'keterangan' => 'Apakah ibu ingin menjadi seorang ibu bekerja atau ingin menjadi ibu rumah tangga?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB006',
                'keterangan' => 'Apakah ada konflik dalam pernikahan? (bias diperhalus bentuk pertanyaannya)',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB007',
                'keterangan' => 'Selama kehamilan apakah suami mendampingi ibu (secara fisik atau emosional)?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB008',
                'keterangan' => 'Bagaimana kondisi finansial ibu dan keluarga?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB009',
                'keterangan' => 'Bagaimana jam tidur ibu dalam satu hari?',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB010',
                'keterangan' => 'Bagaimana nutrisi bagi tubuh ibu selama kehamilan? (apakah lengkap?)',
                'kategori' => 'Kesejahteraan Fisik',
            ],
            [
                'kode' => 'IB011',
                'keterangan' => 'Apakah selama kehamilan ibu memiliki impian untuk proses lahiran yang akan dilalui nanti saat melahirkan? (Caesar/normal)',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB012',
                'keterangan' => 'Selama kehamilan apakah ibu mendapat tekanan dari hal apapun? Kalau iya tekanan apa atau dari pihak mana yang ibu rasakan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
            [
                'kode' => 'IB013',
                'keterangan' => 'Bagaimana hubungan ibu dengan orangtua kandung?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB014',
                'keterangan' => 'Bagaimana hubungan ibu dengan mertua?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB015',
                'keterangan' => 'Ibu lebih nyaman cerita dengan teman (sahabat) atau dengan keluarga (suami, orangtua, mertua)?',
                'kategori' => 'Hubungan Sosial',
            ],
            [
                'kode' => 'IB016',
                'keterangan' => 'Selama kehamilan apakah ibu memiliki support dari orangtua (kandung dan mertua)?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB017',
                'keterangan' => 'Apakah suami memiliki ekspektasi terhadap metode melahirkan yang akan dijalani istri saat melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ],
            [
                'kode' => 'IB018',
                'keterangan' => 'Apakah suami memiliki ekspektasi terhadap metode melahirkan yang akan dijalani istri saat melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB019',
                'keterangan' => 'Apakah selama kehamilan istri memiliki waktu yang cukup untuk berolahraga?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB020',
                'keterangan' => 'Bagaimana suami menyikapi perubahan pada bentuk badan istri selama kehamilan dan setelah melahirkan?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB021',
                'keterangan' => 'Bagaimana proses melahirkan yang dijalani istri?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB022',
                'keterangan' => 'Saat melahirkan, apakah suami mendampingi istri?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB023',
                'keterangan' => 'Apakah orangtua (kandung dan mertua) mendampingi saat kelahiran?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB024',
                'keterangan' => 'Bagaimana perasaan suami saat melihat bayi yang dilahirkan oleh istri?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB025',
                'keterangan' => 'Setelah melahirkan, apakah suami membantu istri dalam merawat bayi?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB026',
                'keterangan' => 'Apakah suami memberikan waktu untuk istri agar memiliki waktu untuk diri sendiri (me-time) setelah melahirkan?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB027',
                'keterangan' => 'Apakah suami memiliki ekspektasi untuk pemberian ASI pada bayi setelah kelahiran?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB028',
                'keterangan' => 'Apakah suami mendukung pemberian ASI kepada bayi?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB029',
                'keterangan' => 'Bagaimana proses pemberian ASI oleh istri kepada bayi?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB030',
                'keterangan' => 'Apakah selama pemberian ASI, istri mengalami rasa sakit pada tubuh?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB031',
                'keterangan' => 'Apakah suami membantu istri dalam proses pengasuhan bayi setelah kelahiran?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB032',
                'keterangan' => 'Bagaimana pembagian waktu pengasuhan bayi antara suami dengan istri?',
                'kategori' => 'Peran dan Dukungan Keluarga',
            ], [
                'kode' => 'IB033',
                'keterangan' => 'Bagaimana jam tidur suami setelah kelahiran bayi?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB034',
                'keterangan' => 'Apakah suami pernah berkomunikasi dengan istri mengenai proses adaptasi yang dialami setelah kelahiran bayi?',
                'kategori' => 'Hubungan Sosial',
            ], [
                'kode' => 'IB035',
                'keterangan' => 'Bagaimana jadwal makan suami setelah kelahiran bayi?',
                'kategori' => 'Kesejahteraan Fisik',
            ], [
                'kode' => 'IB036',
                'keterangan' => 'Apakah suami merasakan kesulitan dalam menjalani peran sebagai orangtua baru?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB037',
                'keterangan' => 'Apakah suami mengalami perubahan suasana hati setelah kelahiran bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB038',
                'keterangan' => 'Apakah suami merasa kewalahan dalam menjalani peran baru sebagai orangtua?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB039',
                'keterangan' => 'Apakah suami memiliki kecemasan terhadap kondisi kesehatan dan keselamatan bayi?',
                'kategori' => 'Kesejahteraan Emosional',
            ], [
                'kode' => 'IB040',
                'keterangan' => 'Apakah suami sering merasa sedih sampai ingin menangis setelah proses persalinan?',
                'kategori' => 'Kesejahteraan Emosional',
            ],
        ]);
    }
}
