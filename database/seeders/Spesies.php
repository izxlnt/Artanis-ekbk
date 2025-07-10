<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class Spesies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Akasia',
            'nama_saintifik' => 'Acacia sp.',
            'kod' => '3000000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );
        
        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Antoi',
            'nama_saintifik' => 'Cyathocalyx spp.',
            'kod' => '7060400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ara berteh',
            'nama_saintifik' => 'Parartocarpus spp.',
            'kod' => '7530500',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ara berteh bukit',
            'nama_saintifik' => 'Parartocarpus bracteatus',
            'kod' => '7530501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ara berteh paya',
            'nama_saintifik' => 'Parartocarpus venenosus',
            'kod' => '7530502',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ara, Jejawi, Kelepong',
            'nama_saintifik' => 'Ficus spp.',
            'kod' => '8530300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Asam Gelugor',
            'nama_saintifik' => 'Garcinia atroviridis',
            'kod' => '7370200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Asam pupoi',
            'nama_saintifik' => 'Sarcotheca spp.',
            'kod' => '7640200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau',
            'nama_saintifik' => 'Shorea spp. (balau)',
            'kod' => '2010500',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau bukit',
            'nama_saintifik' => 'Shorea foxworthyi',
            'kod' => '2010506',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau gajah',
            'nama_saintifik' => 'Shorea submontana',
            'kod' => '2010516',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau gunong',
            'nama_saintifik' => 'Shorea ciliata',
            'kod' => '2010501',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau hitam',
            'nama_saintifik' => 'Shorea atrinervosa',
            'kod' => '2010502',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau kumus',
            'nama_saintifik' => 'Shorea laevis',
            'kod' => '2010510',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau kumus hitam',
            'nama_saintifik' => 'Shorea maxwelliana',
            'kod' => '2010513',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau kuning',
            'nama_saintifik' => 'Shorea falcifera',
            'kod' => '2010505',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau laut',
            'nama_saintifik' => 'Shorea glauca',
            'kod' => '2010507',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau laut merah',
            'nama_saintifik' => 'Shorea kunstleri',
            'kod' => '2010509',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau membatu',
            'nama_saintifik' => 'Shorea guiso',
            'kod' => '2010508',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau membatu jantan',
            'nama_saintifik' => 'Shorea ochrophloia',
            'kod' => '2010514',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau merah',
            'nama_saintifik' => 'Shorea collina',
            'kod' => '2010503',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau pasir',
            'nama_saintifik' => 'Shorea materialis',
            'kod' => '2010512',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau puteh',
            'nama_saintifik' => 'Shorea lumutensis',
            'kod' => '2010511',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau sengkawang ayer',
            'nama_saintifik' => 'Shorea sumatrana',
            'kod' => '2010517',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau sengkawang darat',
            'nama_saintifik' => 'Shorea scrobiculata',
            'kod' => '2010515',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balau tembaga',
            'nama_saintifik' => 'Shorea excelliptica',
            'kod' => '2010504',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Balik angin',
            'nama_saintifik' => 'Mallotus spp.',
            'kod' => '8333600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Batai',
            'nama_saintifik' => 'Albizia spp.',
            'kod' => '0096',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Batang Kelapa',
            'nama_saintifik' => 'Cocos nucifera L.',
            'kod' => '8002',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Batang Sawit',
            'nama_saintifik' => 'Elaesis guineensis',
            'kod' => '8001',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bayur',
            'nama_saintifik' => 'Pterospermum spp.',
            'kod' => '7830800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bayur bukit',
            'nama_saintifik' => 'Schoutenia accrescens',
            'kod' => '7890700',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bebusuk, Johar',
            'nama_saintifik' => 'Cassia',
            'kod' => '7450400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bekak',
            'nama_saintifik' => 'Aglaia spp.',
            'kod' => '7510100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bengang',
            'nama_saintifik' => 'Neesia spp.',
            'kod' => '3110500',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Berangan',
            'nama_saintifik' => 'Castanopsis spp.',
            'kod' => '6340100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Berembang bukit',
            'nama_saintifik' => 'Duabanga grandiflora',
            'kod' => '8810100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Beruas',
            'nama_saintifik' => '-',
            'kod' => '-',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor',
            'nama_saintifik' => 'Calophyllum spp.',
            'kod' => '3370100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor batu',
            'nama_saintifik' => 'Calophyllum teysmannii var. inophylloide',
            'kod' => '3370109',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor bukit',
            'nama_saintifik' => 'Calophyllum symingtonianum',
            'kod' => '3370117',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor bunga',
            'nama_saintifik' => 'Calophyllum calaba var. bracteatum',
            'kod' => '3370105',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor bunut',
            'nama_saintifik' => 'Calophyllum macrocarpum',
            'kod' => '3370111',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor daun karat',
            'nama_saintifik' => 'Calophyllum rubiginosum',
            'kod' => '3370114',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor daun panjang',
            'nama_saintifik' => 'Calophyllum wallichianum var. incrassatum',
            'kod' => '3370108',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor gambut',
            'nama_saintifik' => 'Calophyllum retusum',
            'kod' => '3370113',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor gasing',
            'nama_saintifik' => 'Calophyllum pulcherrimum',
            'kod' => '3370112',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor gunung daun besar',
            'nama_saintifik' => 'Calophyllum coriaceum',
            'kod' => '3370103',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor gunung daun kecil',
            'nama_saintifik' => 'Calophyllum cuneatum',
            'kod' => '3370104',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor jangkang',
            'nama_saintifik' => 'Calophyllum sclerophyllum',
            'kod' => '3370115',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor kelim',
            'nama_saintifik' => 'Calophyllum scriblitifolium',
            'kod' => '3370116',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor kuning',
            'nama_saintifik' => 'Calophyllum tetraptrum',
            'kod' => '3370107',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor laut',
            'nama_saintifik' => 'Calophyllum inophyllum',
            'kod' => '3370110',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor lekok',
            'nama_saintifik' => 'Calophyllum depressinervosum',
            'kod' => '3370106',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor lilin',
            'nama_saintifik' => 'Calophyllum wallichianum',
            'kod' => '3370118',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor Merah',
            'nama_saintifik' => 'Calophyllum canum',
            'kod' => '3370102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bintangor putih',
            'nama_saintifik' => 'Calophyllum alboramulun',
            'kod' => '3370101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bitis',
            'nama_saintifik' => 'Madhuca utilis',
            'kod' => '5770500',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bitis bukit',
            'nama_saintifik' => 'Palaquium stellatum',
            'kod' => '5770813',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bitis paya',
            'nama_saintifik' => 'Palaquium ridleyi',
            'kod' => '5770810',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Bungor',
            'nama_saintifik' => 'Lagerstroemia spp.',
            'kod' => '7480100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Cempedak, Cempedak Air',
            'nama_saintifik' => 'Artocarpus integer',
            'kod' => '6530200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'CHEMPAKA hutan',
            'nama_saintifik' => 'Aromadendron elegans',
            'kod' => '7830800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Chengal',
            'nama_saintifik' => 'Neobalanocarpus heimii',
            'kod' => '2011200',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Cherry',
            'nama_saintifik' => 'Prunus avium',
            'kod' => '2074',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar Hitam',
            'nama_saintifik' => 'Shorea spp. (yellow)',
            'kod' => '0083',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam siput jantan',
            'nama_saintifik' => 'Shorea hopeifolia',
            'kod' => '1010405',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam bulu',
            'nama_saintifik' => 'Shorea longisperma',
            'kod' => '1010407',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam gajah',
            'nama_saintifik' => 'Shorea gibbosa',
            'kod' => '1010404',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam katup',
            'nama_saintifik' => 'Shorea balanocarpoides',
            'kod' => '1010402',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam kelim',
            'nama_saintifik' => 'Shorea blumutensis',
            'kod' => '1010401',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam pipit',
            'nama_saintifik' => 'Shorea multiflora',
            'kod' => '1010409',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam sengkawang putih',
            'nama_saintifik' => 'Shorea maxima',
            'kod' => '1010408',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam siput',
            'nama_saintifik' => 'Shorea faguetiana',
            'kod' => '1010403',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam siput besar',
            'nama_saintifik' => 'Shorea kuantanensis',
            'kod' => '1010406',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar hitam telepok',
            'nama_saintifik' => 'Shorea peltata',
            'kod' => '1010410',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Damar minyak',
            'nama_saintifik' => 'Agathis borneensis',
            'kod' => '3090100',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Dedali',
            'nama_saintifik' => 'Strombosia javanica',
            'kod' => '6610500',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian',
            'nama_saintifik' => 'Durio spp.',
            'kod' => '3110300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  batang',
            'nama_saintifik' => 'Durio malaccensis',
            'kod' => '3110306',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  beludu',
            'nama_saintifik' => 'Durio oxleyanus',
            'kod' => '3110307',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  bujor',
            'nama_saintifik' => 'Durio singaporensis',
            'kod' => '3110309',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  daun',
            'nama_saintifik' => 'Durio lowianus',
            'kod' => '3110304',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  daun besar',
            'nama_saintifik' => 'Durio macrophyllus',
            'kod' => '3110305',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian  daun tajam',
            'nama_saintifik' => 'Durio pinangianus',
            'kod' => '3110308',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian hutan',
            'nama_saintifik' => 'Durio spp.',
            'kod' => '3110300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian ijau laut',
            'nama_saintifik' => 'Durio wyatt-smithii',
            'kod' => '3110310',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian kampong',
            'nama_saintifik' => 'Durio zibethinus',
            'kod' => '3110311',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian merah',
            'nama_saintifik' => 'Durio graveolens',
            'kod' => '3110302',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian paya',
            'nama_saintifik' => 'Durio carinatus',
            'kod' => '3110301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Durian tupai',
            'nama_saintifik' => 'Durio griffithii',
            'kod' => '3110303',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'EKOR',
            'nama_saintifik' => 'Dacrydium',
            'kod' => '3670100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gaham badak',
            'nama_saintifik' => 'Blumeodendron spp.',
            'kod' => '7330900',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gambir Hutan',
            'nama_saintifik' => 'Maesa ramentacea',
            'kod' => '8560300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gapis',
            'nama_saintifik' => 'Saraca spp.',
            'kod' => '7452400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Geronggang',
            'nama_saintifik' => 'Cratoxylum spp.',
            'kod' => '3400100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Geronggang derum',
            'nama_saintifik' => 'Cratoxylum formosum',
            'kod' => '3400103',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Geronggang derum bukit',
            'nama_saintifik' => 'Cratoxylum maingayi',
            'kod' => '3400104',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Geronggang derum seluncor',
            'nama_saintifik' => 'Cratoxylum cochinchinense',
            'kod' => '3400102',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Geronggang geronggang',
            'nama_saintifik' => 'Cratoxylum abrorescens',
            'kod' => '3400101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gerutu',
            'nama_saintifik' => 'Parashorea spp.',
            'kod' => '2011300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gerutu gerutu',
            'nama_saintifik' => 'Parashorea stellata',
            'kod' => '2011303',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gerutu pasir',
            'nama_saintifik' => 'Parashorea denisflora',
            'kod' => '2011301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Gerutu pasir daun besar',
            'nama_saintifik' => 'Parashorea globosa',
            'kod' => '2011302',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam',
            'nama_saintifik' => 'Hopea spp. (giam)',
            'kod' => '2011100',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam',
            'nama_saintifik' => 'Hopea nutans',
            'kod' => '2011105',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam bayan',
            'nama_saintifik' => 'Hopea pachycarpa',
            'kod' => '2011106',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam hantu',
            'nama_saintifik' => 'Hopea coriacea',
            'kod' => '2011102',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam jantan',
            'nama_saintifik' => 'Hopea semicuneata',
            'kod' => '2011109',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam kanching',
            'nama_saintifik' => 'Hopea subalata',
            'kod' => '6011110',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam lintah bukit',
            'nama_saintifik' => 'Hopea helferi',
            'kod' => '2011104',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam malut',
            'nama_saintifik' => 'Hopea ferrea',
            'kod' => '2011103',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam melukut',
            'nama_saintifik' => 'Hopea apiculata',
            'kod' => '6011101',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam palong',
            'nama_saintifik' => 'Hopea pierrei',
            'kod' => '2011107',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Giam rambai',
            'nama_saintifik' => 'Hopea polyalthioides',
            'kod' => '6011108',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Hampas tebu',
            'nama_saintifik' => 'Gironniera subaequalis',
            'kod' => '8910200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Hard Maple',
            'nama_saintifik' => 'Acer saccharum',
            'kod' => '2016',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Hujan panas',
            'nama_saintifik' => 'Breynia spp.',
            'kod' => '8331100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Hujan-hujan',
            'nama_saintifik' => 'Samanea saman',
            'kod' => '0072',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Inggir burung',
            'nama_saintifik' => 'Ixonanthes reticulata',
            'kod' => '7460200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ipoh',
            'nama_saintifik' => 'Antiaris toxicaria',
            'kod' => '6530100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jangkang',
            'nama_saintifik' => 'Xylopia spp.',
            'kod' => '3062500',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jangkang bukit',
            'nama_saintifik' => 'Xylopia ferruginea',
            'kod' => '3062501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jangkang paya',
            'nama_saintifik' => 'Xylopia fusca',
            'kod' => '3062502',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jati',
            'nama_saintifik' => 'Tectona grandis',
            'kod' => '0023',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelawai',
            'nama_saintifik' => 'Terminalia spp.',
            'kod' => '7180200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelawai jaha',
            'nama_saintifik' => 'Terminalia subspathulata',
            'kod' => '7180204',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelawai ketapang',
            'nama_saintifik' => 'Terminalia catappa',
            'kod' => '7180202',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelawai mempelam babi',
            'nama_saintifik' => 'Terminalia phellocarpa',
            'kod' => '7180203',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelawai mentalun',
            'nama_saintifik' => 'Terminalia calamansanai',
            'kod' => '7180201',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelutong',
            'nama_saintifik' => 'Dyera costulata',
            'kod' => '3070300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jelutong Bedak',
            'nama_saintifik' => 'Tabernaemontana sp.',
            'kod' => '7070900',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Jenjulong',
            'nama_saintifik' => 'Agrostistachys spp.',
            'kod' => '7330200',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kamap',
            'nama_saintifik' => 'Strombosia ceylanica',
            'kod' => '6610500',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kapur',
            'nama_saintifik' => 'Dryobalanops aromatica',
            'kod' => '2010901',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas / Gaharu',
            'nama_saintifik' => 'Aquilaria spp',
            'kod' => '7880100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas batu',
            'nama_saintifik' => 'Aquilaria beccariana',
            'kod' => '7880101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas Buah',
            'nama_saintifik' => 'Aquilaria beccariana',
            'kod' => '7880102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas bulu',
            'nama_saintifik' => 'Aquilaria hirta',
            'kod' => '7880103',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas candan',
            'nama_saintifik' => 'Aquilaria malaccensis',
            'kod' => '7880104',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Karas minyak',
            'nama_saintifik' => 'Aquilaria rostrata',
            'kod' => '7880105',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kasah',
            'nama_saintifik' => 'Pterygota spp',
            'kod' => '7830900',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kasai',
            'nama_saintifik' => 'Pometia spp',
            'kod' => '6751500',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kasai daun besar',
            'nama_saintifik' => 'Pometia pinnata',
            'kod' => '6751501',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kasai daun kecil',
            'nama_saintifik' => 'Pometia pinnata f. alnifolia',
            'kod' => '6751502',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kasai daun licin',
            'nama_saintifik' => 'Pometia ridleyi',
            'kod' => '6751503',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kayu arang / Kayu malam',
            'nama_saintifik' => 'Diospyros spp.',
            'kod' => '6280100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kayu Getah',
            'nama_saintifik' => 'Hevea brasilliensis',
            'kod' => '0051',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kayu Jaras',
            'nama_saintifik' => '-',
            'kod' => '0064',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong',
            'nama_saintifik' => 'BURSERACEAE',
            'kod' => '3130000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong bulan',
            'nama_saintifik' => 'Canarium littorale',
            'kod' => '3130002',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong bulan bulu',
            'nama_saintifik' => 'Canarium litt. F. tomentosum',
            'kod' => '3130005',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong gergaji',
            'nama_saintifik' => 'Canarium litt. F. rufum',
            'kod' => '3130004',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kemansul',
            'nama_saintifik' => 'Canarium apertum',
            'kod' => '3130001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kerantai',
            'nama_saintifik' => 'Santiria spp.',
            'kod' => '3130400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kerantai bulu',
            'nama_saintifik' => 'Santiria tomentosa',
            'kod' => '3130402',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kerantai licin',
            'nama_saintifik' => 'Santiria laevigata',
            'kod' => '3130401',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong keruing',
            'nama_saintifik' => 'Canarium megalanthum',
            'kod' => '3130006',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kerut',
            'nama_saintifik' => 'Dacryodes rostrata',
            'kod' => '3130203',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong kijai',
            'nama_saintifik' => 'Triomma malaccensis',
            'kod' => '3130601',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong matahari',
            'nama_saintifik' => 'Dacryodes rugosa',
            'kod' => '3130204',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong mempelas',
            'nama_saintifik' => 'Dacryodes laxa',
            'kod' => '3130201',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong putih',
            'nama_saintifik' => 'Canarium litt. F. purpurascens',
            'kod' => '3130003',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong senggeh',
            'nama_saintifik' => 'Canarium Pseudosumatranum',
            'kod' => '3130007',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong sengkuang',
            'nama_saintifik' => 'Scutinanthe brunnea',
            'kod' => '3130501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kedondong serong',
            'nama_saintifik' => 'Dacryodes puberula',
            'kod' => '3130202',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kekabu hutan',
            'nama_saintifik' => 'Bombax valetonii',
            'kod' => '7110100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kekatong',
            'nama_saintifik' => 'Cynometra spp.',
            'kod' => '5450600',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kekatong kakatong',
            'nama_saintifik' => 'Cynometra malaccensis',
            'kod' => '5450602',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kekatong laut',
            'nama_saintifik' => 'Cynometra iripa',
            'kod' => '5450601',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keladan',
            'nama_saintifik' => 'Dryobalanops oblongifolia',
            'kod' => '2010902',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelat',
            'nama_saintifik' => 'Syzygium spp.',
            'kod' => '7570300',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelat gelam',
            'nama_saintifik' => 'Syzygium cerrinum',
            'kod' => '7570301',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelat jambu laut',
            'nama_saintifik' => 'Syzygium grande',
            'kod' => '7570303',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelat merah',
            'nama_saintifik' => 'Syzygium chloranthum',
            'kod' => '7570302',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelat paya',
            'nama_saintifik' => 'Syzygium papillosum',
            'kod' => '7570304',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang',
            'nama_saintifik' => 'Artocarpus spp.',
            'kod' => '4530200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang babi',
            'nama_saintifik' => 'Artocarpus anisophyllus',
            'kod' => '4530201',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang bangkong',
            'nama_saintifik' => 'Artocarpus silvestris',
            'kod' => '4530209',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang keledang',
            'nama_saintifik' => 'Artocarpus lanceifolius',
            'kod' => '4530211',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang tampang',
            'nama_saintifik' => 'Artocarpus nitidus',
            'kod' => '4530213',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang tampang bulu',
            'nama_saintifik' => 'Artocarpus dadah',
            'kod' => '4530203',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang tampang gajah',
            'nama_saintifik' => 'Artocarpus fulvicortex',
            'kod' => '4530205',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang tampang hitam',
            'nama_saintifik' => 'Artocarpus gomezianus',
            'kod' => '4530206',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keledang temponek',
            'nama_saintifik' => 'Artocarpus rigidus',
            'kod' => '4530214',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelempayan',
            'nama_saintifik' => 'Neolamarkia cadamba',
            'kod' => '8713001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kelumpang',
            'nama_saintifik' => 'Sterculia spp.',
            'kod' => '7831100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kembang semangkok',
            'nama_saintifik' => 'Scaphium spp.',
            'kod' => '3831000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kembang semangkok bulat',
            'nama_saintifik' => 'Scaphium linearicarpum',
            'kod' => '3831001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kembang semangkok jantung',
            'nama_saintifik' => 'Scaphium macropodum',
            'kod' => '3831002',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kemenyan',
            'nama_saintifik' => 'Styrax spp.',
            'kod' => '7840100',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kempas',
            'nama_saintifik' => 'Koompasia',
            'kod' => '4451302',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kemuning hutan/Gading',
            'nama_saintifik' => 'Hunteria zeylanica',
            'kod' => '7070400',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kenanga',
            'nama_saintifik' => 'Cananga',
            'kod' => '7060300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kenidai',
            'nama_saintifik' => 'Bridelia stipularis',
            'kod' => '8331200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji',
            'nama_saintifik' => 'Dialiumspp.',
            'kod' => '5450800',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji bulu',
            'nama_saintifik' => 'Dialium kingii',
            'kod' => '5450801',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji kuning besar',
            'nama_saintifik' => 'Dialium platysepalum',
            'kod' => '5450805',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji kuning kecil',
            'nama_saintifik' => 'Dialium wallichii',
            'kod' => '5450807',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji paya',
            'nama_saintifik' => 'Dialium indum',
            'kod' => '5450804',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji tebal besar',
            'nama_saintifik' => 'Dialium laurinum',
            'kod' => '5450802',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji tebal kecil',
            'nama_saintifik' => 'Dialium maingayi',
            'kod' => '5450803',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keranji tunggal',
            'nama_saintifik' => 'Dialium procerum',
            'kod' => '5450806',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kerdas, Jering',
            'nama_saintifik' => 'Pithecellobium bubalinum',
            'kod' => '3452101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing',
            'nama_saintifik' => 'Dipterocarpus spp.',
            'kod' => '0016',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing baran',
            'nama_saintifik' => 'Dipterocarpus eurhynchus',
            'kod' => '2010807',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing belimbing',
            'nama_saintifik' => 'Dipterocarpus grandiflorus',
            'kod' => '2010810',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing beludu',
            'nama_saintifik' => 'Dipterocarpus obtusifolius',
            'kod' => '2010813',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing berminyak',
            'nama_saintifik' => 'Dipterocarpus spp. (oily)',
            'kod' => '2010700',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing bukit',
            'nama_saintifik' => 'Dipterocarpus costatus',
            'kod' => '2010805',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing bulu',
            'nama_saintifik' => 'Dipterocarpus baudii',
            'kod' => '2010701',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing chogan',
            'nama_saintifik' => 'Dipterocarpus rigidus',
            'kod' => '2010817',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing etoi',
            'nama_saintifik' => 'Dipterocarpus dyeri',
            'kod' => '2010705',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing gasing',
            'nama_saintifik' => 'Dipterocarpus caudatus',
            'kod' => '2010802',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing gombang',
            'nama_saintifik' => 'Dipterocarpus cornutus',
            'kod' => '2010703',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing gombang merah',
            'nama_saintifik' => 'Dipterocarpus kunstleri',
            'kod' => '2010812',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing gondol',
            'nama_saintifik' => 'Dipterocarpus kerrii',
            'kod' => '2010706',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing gunung',
            'nama_saintifik' => 'Dipterocarpus retusus',
            'kod' => '2010816',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing kelabu',
            'nama_saintifik' => 'Dipterocarpus fagineus',
            'kod' => '2010815',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing kertas',
            'nama_saintifik' => 'Dipterocarpus chartaceus',
            'kod' => '2010702',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing kerut',
            'nama_saintifik' => 'Dipterocarpus sublamellatus',
            'kod' => '2010821',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing kesat',
            'nama_saintifik' => 'Dipterocarpus gracilis',
            'kod' => '2010809',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing kipas',
            'nama_saintifik' => 'Dipterocarpus costulatus',
            'kod' => '2010806',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing latek',
            'nama_saintifik' => 'Dipterocarpus elongatus',
            'kod' => '2010801',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing mempelas',
            'nama_saintifik' => 'Dipterocarpus crinitus',
            'kod' => '2010704',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing mengkai',
            'nama_saintifik' => 'Dipterocarpus rotundifolius',
            'kod' => '2010818',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing merah',
            'nama_saintifik' => 'Dipterocarpus verrucosus',
            'kod' => '2010709',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing neram',
            'nama_saintifik' => 'Dipterocarpus oblongifolius',
            'kod' => '2010822',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing padi',
            'nama_saintifik' => 'Dipterocarpus semivestitus',
            'kod' => '2010820',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing paya',
            'nama_saintifik' => 'Dipterocarpus coriaceus',
            'kod' => '2010804',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing perak',
            'nama_saintifik' => 'Dipterocarpus perakensis',
            'kod' => '2010814',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing pipit',
            'nama_saintifik' => 'Dipterocarpus fagineus',
            'kod' => '2010808',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing ropol',
            'nama_saintifik' => 'Dipterocarpus hasseltii',
            'kod' => '2010811',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing sarawak',
            'nama_saintifik' => 'Dipterocarpus sarawakensis',
            'kod' => '2010819',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing sendok',
            'nama_saintifik' => 'Dipterocarpus concavus',
            'kod' => '2010803',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing sol',
            'nama_saintifik' => 'Dipterocarpus lowii',
            'kod' => '2010707',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing ternek',
            'nama_saintifik' => 'Dipterocarpus palembanicus',
            'kod' => '2010708',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Keruing tidak berminyak',
            'nama_saintifik' => 'Dipterocarpus spp. (non oily)',
            'kod' => '2010800',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Khaya',
            'nama_saintifik' => 'Khaya sp.',
            'kod' => '-',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kubin, mahang',
            'nama_saintifik' => 'Macarangga spp.',
            'kod' => '8333500',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kulim',
            'nama_saintifik' => 'Scorodocarpus borneensis',
            'kod' => '6610401',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kundang',
            'nama_saintifik' => 'Bouea spp.',
            'kod' => '7050200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Kungkur',
            'nama_saintifik' => 'Pithecellobium splendens',
            'kod' => '3452102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Lain-Lain Kayu Keras Berat',
            'nama_saintifik' => '-',
            'kod' => '9009',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Lain-Lain Kayu Keras Ringan',
            'nama_saintifik' => '-',
            'kod' => '9048',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Lain-Lain Kayu Keras Sederhana',
            'nama_saintifik' => '-',
            'kod' => '9024',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Langsat',
            'nama_saintifik' => 'Lansium domesticum',
            'kod' => '7510800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Lanjut',
            'nama_saintifik' => 'Mangifera lagenifera',
            'kod' => '3050802',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Leban',
            'nama_saintifik' => 'Vitex spp.',
            'kod' => '8930900',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ludai',
            'nama_saintifik' => 'Sapium baccatum',
            'kod' => '8334601',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Machang',
            'nama_saintifik' => 'Mangifera spp.',
            'kod' => '3050800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Machang-machang',
            'nama_saintifik' => 'Mangifera spp.',
            'kod' => '3050800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mahang Gajah',
            'nama_saintifik' => 'Macaranga gigantea',
            'kod' => '8333501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mahang Merah',
            'nama_saintifik' => 'Macaranga triloba',
            'kod' => '8333503',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mahang Putih',
            'nama_saintifik' => 'Macaranga hypoleuca',
            'kod' => '8333502',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mahogany',
            'nama_saintifik' => '-',
            'kod' => '-',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Malabera bukit',
            'nama_saintifik' => 'Mussaendopsis beccariana',
            'kod' => '7712700',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mangga',
            'nama_saintifik' => 'Mangifera indica',
            'kod' => '3050801',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Manggis, Kandis',
            'nama_saintifik' => 'Garcinia spp.',
            'kod' => '7370200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Maple',
            'nama_saintifik' => 'Acer',
            'kod' => '2082',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mata keli',
            'nama_saintifik' => 'Gynotraoches axilaris',
            'kod' => '4690600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mata ulat',
            'nama_saintifik' => 'Kokoona spp.',
            'kod' => '7160500',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Medang',
            'nama_saintifik' => 'LAURACEAE',
            'kod' => '6430000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Medang kemangi',
            'nama_saintifik' => 'Cinnamomum porrectum',
            'kod' => '6430502',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Medang payong',
            'nama_saintifik' => 'Actinodaphne spp.',
            'kod' => '6430100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Medang teja',
            'nama_saintifik' => 'Cinnamomum javanicum',
            'kod' => '6430501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Melembu',
            'nama_saintifik' => 'Pterocymbium javanicum',
            'kod' => '7830700',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Melunak',
            'nama_saintifik' => 'Pentace spp.',
            'kod' => '6890600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Melunak bukit',
            'nama_saintifik' => 'Pentace curtisii',
            'kod' => '6890601',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Melunak pusat beludu',
            'nama_saintifik' => 'Pentace triptera',
            'kod' => '6890602',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Membuluh',
            'nama_saintifik' => 'Pellacalyx spp.',
            'kod' => '4690800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mempening',
            'nama_saintifik' => 'Lithocarpus spp.',
            'kod' => '6340200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mempisang',
            'nama_saintifik' => 'ANNONACEAE',
            'kod' => '3060000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mempoyan',
            'nama_saintifik' => 'Rhodamnia cinerea',
            'kod' => '7570700',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Menarong, Mengkirai',
            'nama_saintifik' => 'Trema spp.',
            'kod' => '8910300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mendong',
            'nama_saintifik' => 'Elaeocarpus spp.',
            'kod' => '8290100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mengkudu',
            'nama_saintifik' => 'Morinda citrifolia',
            'kod' => '7712600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mengkulang',
            'nama_saintifik' => 'Heritiera spp.',
            'kod' => '4830300',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mengkulang jari',
            'nama_saintifik' => 'Heritiera javanica',
            'kod' => '4830301',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mengkulang jari bulu',
            'nama_saintifik' => 'Heritiera sumatrana',
            'kod' => '4830303',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mengkulang siku keluang',
            'nama_saintifik' => 'Heritiera simplicifolia',
            'kod' => '4830302',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'MENGKUNDOR',
            'nama_saintifik' => 'Tetrameles nudifelora',
            'kod' => '7260100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meraga',
            'nama_saintifik' => 'Pertusadina euryncha',
            'kod' => '7713400',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meransi',
            'nama_saintifik' => 'Carallia brachiata',
            'kod' => '4690300',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti bakau',
            'nama_saintifik' => 'Shorea uliginosa',
            'kod' => '1010214',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti batu',
            'nama_saintifik' => 'Shorea dasyphylla',
            'kod' => '1010202',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti belang',
            'nama_saintifik' => 'Shorea resinosa',
            'kod' => '1010309',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti bukit',
            'nama_saintifik' => 'Shorea platyclados',
            'kod' => '1010103',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti bumbung',
            'nama_saintifik' => 'Shorea dealbata',
            'kod' => '1010304',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti bunga',
            'nama_saintifik' => 'Shorea teysmanniana',
            'kod' => '1010213',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti daun besar',
            'nama_saintifik' => 'Shorea hemsleyana',
            'kod' => '1010203',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti jerit',
            'nama_saintifik' => 'Shorea henryana',
            'kod' => '1010306',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti kepong',
            'nama_saintifik' => 'Shorea ovalis',
            'kod' => '1010209',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti kepong hantu',
            'nama_saintifik' => 'Shorea macranhta',
            'kod' => '1010207',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti kuning',
            'nama_saintifik' => 'Shorea spp. (yellow)',
            'kod' => '1010400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti langgong',
            'nama_saintifik' => 'Shorea lepidota',
            'kod' => '1010205',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti lapis',
            'nama_saintifik' => 'Shorea lamellata',
            'kod' => '1010308',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti laut',
            'nama_saintifik' => 'Shorea gratissima',
            'kod' => '1010305',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti melantai',
            'nama_saintifik' => 'Shorea macroptera',
            'kod' => '1010208',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti mengkai',
            'nama_saintifik' => 'Shorea bentongensis',
            'kod' => '1010302',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti merah',
            'nama_saintifik' => 'Shorea spp. (red)',
            'kod' => '1010000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti merah muda',
            'nama_saintifik' => 'Shorea spp. (light red)',
            'kod' => '1010200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti merah tua',
            'nama_saintifik' => 'Shorea spp. (dark red)',
            'kod' => '1010000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti nemesu',
            'nama_saintifik' => 'Shorea pauciflora',
            'kod' => '1010104',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti paang',
            'nama_saintifik' => 'Shorea bracteolata',
            'kod' => '1010303',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti paya',
            'nama_saintifik' => 'Shorea platycarpa',
            'kod' => '1010212',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti pepijat',
            'nama_saintifik' => 'Shorea johorensis',
            'kod' => '1010204',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti pipit',
            'nama_saintifik' => 'Shorea assamica',
            'kod' => '1010301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti putih',
            'nama_saintifik' => 'Shorea spp. (white)',
            'kod' => '1010300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti rambai daun',
            'nama_saintifik' => 'Shorea acuminata',
            'kod' => '1010201',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti sarang punai',
            'nama_saintifik' => 'Shorea parvifolia',
            'kod' => '1010211',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti sarang punai bukit',
            'nama_saintifik' => 'Shorea ovata',
            'kod' => '1010102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti sengkawang merah',
            'nama_saintifik' => 'Shorea singkawang',
            'kod' => '1010105',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti seraya',
            'nama_saintifik' => 'Shorea curtisii',
            'kod' => '1010101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti temak',
            'nama_saintifik' => 'Shorea hypochra',
            'kod' => '1010307',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti temak nipis',
            'nama_saintifik' => 'Shorea roxburghii',
            'kod' => '1010310',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti tembaga',
            'nama_saintifik' => 'Shorea leprosula',
            'kod' => '1010206',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meranti tengkawang air',
            'nama_saintifik' => 'Shorea palembanica',
            'kod' => '1010210',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan',
            'nama_saintifik' => 'Hopea spp. (Merawan)',
            'kod' => '2011000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan batu',
            'nama_saintifik' => 'Hopea beccariana',
            'kod' => '2011001',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan bunga',
            'nama_saintifik' => 'Hopea pubescens',
            'kod' => '2011017',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan daun bulat',
            'nama_saintifik' => 'Hopea latifolia',
            'kod' => '2011012',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan gunung',
            'nama_saintifik' => 'Hopea montana',
            'kod' => '2011013',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan jangkang',
            'nama_saintifik' => 'Hopea nervosa',
            'kod' => '2011015',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan jantan',
            'nama_saintifik' => 'Hopea griffithii',
            'kod' => '2011008',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan jeruai',
            'nama_saintifik' => 'Hopea sublanceolata',
            'kod' => '2011010',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan kelabu',
            'nama_saintifik' => 'Hopea cescens',
            'kod' => '2011004',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan mata kucing beludu',
            'nama_saintifik' => 'Hopea myrtifolia',
            'kod' => '2011014',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan mata kucing bukit',
            'nama_saintifik' => 'Hopea pedicellata',
            'kod' => '2011003',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan mata kucing hitam',
            'nama_saintifik' => 'Hopea dryobalanoides',
            'kod' => '6011005',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan mata kucing merah',
            'nama_saintifik' => 'Hopea ferruginea',
            'kod' => '6011007',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan mata kucing pipit',
            'nama_saintifik' => 'Hopea johorensis',
            'kod' => '2011009',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan meranti',
            'nama_saintifik' => 'Hopea sulcata',
            'kod' => '2011019',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan palit',
            'nama_saintifik' => 'Hopea dyeri',
            'kod' => '6011006',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan penak',
            'nama_saintifik' => 'Hopea mengarawan',
            'kod' => '2011011',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan siput',
            'nama_saintifik' => 'Hopea sangal',
            'kod' => '2011018',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan siput jantan',
            'nama_saintifik' => 'Hopea odorata',
            'kod' => '2011016',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merawan ungu',
            'nama_saintifik' => 'Hopea bracteata',
            'kod' => '6011002',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merbatu',
            'nama_saintifik' => 'Atuna spp.',
            'kod' => '6700100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merbatu pipit',
            'nama_saintifik' => 'Parinari costata',
            'kod' => '6700701',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merbau',
            'nama_saintifik' => 'Intsia palembanica',
            'kod' => '5451201',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merbau Ipil',
            'nama_saintifik' => 'Intsia bijua',
            'kod' => '5451201',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Meribut',
            'nama_saintifik' => 'Diospyrus spp.',
            'kod' => '6280100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merpauh',
            'nama_saintifik' => 'Swintonia spp.',
            'kod' => '6051600',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merpauh daun runcing',
            'nama_saintifik' => 'Swintonia floribunda var penangiana',
            'kod' => '6051601',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merpauh daun tebal',
            'nama_saintifik' => 'Swintonia spicifera',
            'kod' => '6051602',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Merpauh periang',
            'nama_saintifik' => 'Swintonia schwenkii',
            'kod' => '6051603',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa',
            'nama_saintifik' => 'Anisoptera spp.',
            'kod' => '2010600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa durian',
            'nama_saintifik' => 'Anisoptera laevis',
            'kod' => '2010603',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa gajah',
            'nama_saintifik' => 'Anisoptera scaphula',
            'kod' => '2010606',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa kesat',
            'nama_saintifik' => 'Anisoptera costata',
            'kod' => '2010601',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa kuning',
            'nama_saintifik' => 'Anisoptera curtisii',
            'kod' => '2010602',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa merah',
            'nama_saintifik' => 'Anisoptera megistocarpa',
            'kod' => '2010605',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mersawa paya',
            'nama_saintifik' => 'Anisoptera marginata',
            'kod' => '2010604',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Mertas',
            'nama_saintifik' => 'Ctenoplophon parvifolius',
            'kod' => '7460100',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Miku',
            'nama_saintifik' => 'Artocarpus lowii',
            'kod' => '4530212',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Minyak berok',
            'nama_saintifik' => 'Xantophyllum spp.',
            'kod' => '6680100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nangka',
            'nama_saintifik' => 'Artocarpus heterophyllus',
            'kod' => '4530207',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nemali',
            'nama_saintifik' => 'Leea spp.',
            'kod' => '7940100',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nipis kulit',
            'nama_saintifik' => 'Memecylon spp.',
            'kod' => '8500200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh',
            'nama_saintifik' => 'SAPOTACEAE',
            'kod' => '3770000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh Durian',
            'nama_saintifik' => 'Payena maingayi',
            'kod' => '3770900',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh ekor',
            'nama_saintifik' => 'Payena lanceolata',
            'kod' => '3770901',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh gunong',
            'nama_saintifik' => 'Palaquium reginamontium',
            'kod' => '3770809',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh Jambak',
            'nama_saintifik' => 'P. hexandrum',
            'kod' => '3770802',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh kabu',
            'nama_saintifik' => 'Palaquium xanthochymum',
            'kod' => '3770815',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh ketiau',
            'nama_saintifik' => 'Madhuca motleyana',
            'kod' => '3770301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh mayang',
            'nama_saintifik' => 'Palaquium sukoei',
            'kod' => '3770814',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh nangka kuning',
            'nama_saintifik' => 'Pouteria malaccensis',
            'kod' => '3771100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh nangka merah',
            'nama_saintifik' => 'Pouteria maingayi',
            'kod' => '3771001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh pipit',
            'nama_saintifik' => 'Palaquium microphyllum',
            'kod' => '3770806',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh putih',
            'nama_saintifik' => 'Palaquium obovatum',
            'kod' => '3770807',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh semaram',
            'nama_saintifik' => 'Palaquium semaram',
            'kod' => '3770812',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh sidang',
            'nama_saintifik' => 'Palaquium rostratum',
            'kod' => '3770811',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh sundek',
            'nama_saintifik' => 'Payena obscura',
            'kod' => '3770903',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh surin',
            'nama_saintifik' => 'Palaquium impressinervium',
            'kod' => '3770804',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh taban merah',
            'nama_saintifik' => 'Palaquium gutta',
            'kod' => '3770801',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh taban putih',
            'nama_saintifik' => 'Palaquium oxleyanum',
            'kod' => '3770808',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh tembaga',
            'nama_saintifik' => 'Palaquium maingayi',
            'kod' => '3770805',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Nyatoh tembaga kuning',
            'nama_saintifik' => 'Palaquium hispidum',
            'kod' => '3770803',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Okoume',
            'nama_saintifik' => 'Aucoume klaineana',
            'kod' => '2083',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Otak udang',
            'nama_saintifik' => 'Buchanania spp.',
            'kod' => '7050300',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pagar anak',
            'nama_saintifik' => 'Ixonanthes icosandra',
            'kod' => '7460200',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pauh kijang',
            'nama_saintifik' => 'Irvingia malayana',
            'kod' => '6800401',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'PELAWAN',
            'nama_saintifik' => 'Tristania spp.',
            'kod' => '7570800',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pelong',
            'nama_saintifik' => 'Pentaspadon spp.',
            'kod' => '3051100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pelong beludu',
            'nama_saintifik' => 'Pentaspadon velutinus',
            'kod' => '3051102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pelong licin',
            'nama_saintifik' => 'Pentaspadon motleyi',
            'kod' => '3051101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penaga',
            'nama_saintifik' => 'Mesua ferrea',
            'kod' => '7370401',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penarahan',
            'nama_saintifik' => 'Myryisticaceae',
            'kod' => '6550000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penarahan arang',
            'nama_saintifik' => 'Myristica cinnamomea',
            'kod' => '6550401',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penarahan arang ayer',
            'nama_saintifik' => 'Myristica elliptica',
            'kod' => '6550402',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penarahan arang bukit',
            'nama_saintifik' => 'Myristica maingayi',
            'kod' => '6550404',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Penarahan arang gambut',
            'nama_saintifik' => 'Myristica lowiana',
            'kod' => '6550403',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pepauh',
            'nama_saintifik' => 'Melicope spp.',
            'kod' => '7720600',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Perah',
            'nama_saintifik' => 'Elateriospermum tapos',
            'kod' => '7332301',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Perah ikan',
            'nama_saintifik' => 'Pimeleodendron griffthianum',
            'kod' => '7334301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Perupok',
            'nama_saintifik' => 'Lophopetalum spp.',
            'kod' => '7160600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Petai',
            'nama_saintifik' => 'Parkia speciosa',
            'kod' => '7451800',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Petai kerayong',
            'nama_saintifik' => 'Parkia timoriana',
            'kod' => '7451801',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Petai meranti',
            'nama_saintifik' => 'Parkia singularis',
            'kod' => '7451802',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Petai petai',
            'nama_saintifik' => 'Parkia speciosa',
            'kod' => '7451803',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Petaling',
            'nama_saintifik' => 'Ochanostachys amentacea',
            'kod' => '6610300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pine',
            'nama_saintifik' => 'Pinus',
            'kod' => '2084',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo',
            'nama_saintifik' => 'Podocarpus spp.',
            'kod' => '3670200',
            'kumpulan_kayu_id' => 4,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo bukit',
            'nama_saintifik' => 'Podocarpus neriifolius',
            'kod' => '3670203',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo cucor atap',
            'nama_saintifik' => 'Dacrycarpus imbricartus',
            'kod' => '3670201',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo kebal musang',
            'nama_saintifik' => 'Podocarpus motleyi',
            'kod' => '3670202',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo kebal musang gunong',
            'nama_saintifik' => 'Podocarpus wallichianus',
            'kod' => '3670205',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Podo laut',
            'nama_saintifik' => 'Podocarpus polystachyus',
            'kod' => '3670204',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulai',
            'nama_saintifik' => 'Alstonia spp.',
            'kod' => '8070100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulai basong',
            'nama_saintifik' => 'Alstonia spatulata',
            'kod' => '8070104',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulai penipu bukit',
            'nama_saintifik' => 'Alstonia macrophylla',
            'kod' => '8070103',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulai penipu paya',
            'nama_saintifik' => 'Alstonia angustifolia',
            'kod' => '8070102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulai pulai',
            'nama_saintifik' => 'Alstonia angustiloba',
            'kod' => '8070101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Pulasan',
            'nama_saintifik' => 'Nephelium spp.',
            'kod' => '7751300',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Punah',
            'nama_saintifik' => 'Tetramerista glabra',
            'kod' => '4870101',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Punggai',
            'nama_saintifik' => 'Coelostegia griffithii',
            'kod' => '3110200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Punggai daun besar',
            'nama_saintifik' => 'Coelostegia borneensis',
            'kod' => '3110201',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Putat',
            'nama_saintifik' => 'Barringtonia spp.',
            'kod' => '7440100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rambai, Tampoi, Setambun',
            'nama_saintifik' => 'Baccaurea spp.',
            'kod' => '7330800',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rambutan',
            'nama_saintifik' => 'Nephelium spp.',
            'kod' => '7751300',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rambutan hutan',
            'nama_saintifik' => 'Nephelium lappaceum',
            'kod' => '7751303',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rambutan pacat',
            'nama_saintifik' => 'Xerospermum spp.',
            'kod' => '7751700',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin',
            'nama_saintifik' => 'Gonystylus spp.',
            'kod' => '3880200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin dara elok',
            'nama_saintifik' => 'Gonystylus affinis',
            'kod' => '3880201',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin daun tebal',
            'nama_saintifik' => 'Gonystylus brunnescens',
            'kod' => '3880203',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin melawis',
            'nama_saintifik' => 'Gonystylus bancanus',
            'kod' => '3880202',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin pinang muda',
            'nama_saintifik' => 'Gonystylus confusus',
            'kod' => '3880204',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ramin pipit',
            'nama_saintifik' => 'Gonystylus maingayi',
            'kod' => '3880205',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'RAWA',
            'nama_saintifik' => 'Mangifera microphylla',
            'kod' => '3050804',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Red Oak',
            'nama_saintifik' => 'Quercus rubra',
            'kod' => '2086',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Redan',
            'nama_saintifik' => 'Nephelium maingayi',
            'kod' => '7751302',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rengas',
            'nama_saintifik' => 'Gluta spp.',
            'kod' => '6050700',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rengas ayer',
            'nama_saintifik' => 'Gluta wrayi',
            'kod' => '6050701',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rengas kerbau jalang',
            'nama_saintifik' => 'Gluta aptera',
            'kod' => '6050701',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rengas pacat',
            'nama_saintifik' => 'Gluta spp.',
            'kod' => '6050900',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rengas padi',
            'nama_saintifik' => 'Melanochyla auriculata',
            'kod' => '6050901',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak',
            'nama_saintifik' => 'Vatica yeechongii',
            'kod' => '2011423',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak',
            'nama_saintifik' => 'Cotylelobium / Vatica spp',
            'kod' => '2011400',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak buah kana',
            'nama_saintifik' => 'Vatica ridleyana',
            'kod' => '2011418',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak bukit',
            'nama_saintifik' => 'Cotylelobium lanceolatum',
            'kod' => '2011410',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak daun panjang',
            'nama_saintifik' => 'Vatica nitens',
            'kod' => '2011413',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak daun runcing',
            'nama_saintifik' => 'Vatica cuspidata',
            'kod' => '2011403',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak degong',
            'nama_saintifik' => 'Vatica havilandii',
            'kod' => '2011405',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak gajah',
            'nama_saintifik' => 'Vatica sp A ',
            'kod' => '2011420',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak gunong',
            'nama_saintifik' => 'Vatica heteroptera ',
            'kod' => '2011406',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak julong',
            'nama_saintifik' => 'Vatica mangachapoi ',
            'kod' => '2011411',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak kecil',
            'nama_saintifik' => 'Vatica pallida ',
            'kod' => '2011415',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak keluang',
            'nama_saintifik' => 'Vatica bella ',
            'kod' => '2011401',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak langgong',
            'nama_saintifik' => 'Vatica scortechinii ',
            'kod' => '2011419',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak laru',
            'nama_saintifik' => 'Vatica pauciflora ',
            'kod' => '2011416',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak laut',
            'nama_saintifik' => 'Vatica cinerea ',
            'kod' => '2011402',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak letop',
            'nama_saintifik' => 'Vatica venulosa ',
            'kod' => '2011422',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak lidi',
            'nama_saintifik' => 'Vatica maingayi ',
            'kod' => '2011409',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak mempening',
            'nama_saintifik' => 'Vatica stapfiana ',
            'kod' => '2011421',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak padi',
            'nama_saintifik' => 'Vatica flavida ',
            'kod' => '2011404',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak paya',
            'nama_saintifik' => 'Vatica lobata ',
            'kod' => '2011407',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak pipit',
            'nama_saintifik' => 'Vatica lowii ',
            'kod' => '2011408',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak putih',
            'nama_saintifik' => 'Vatica perakensis ',
            'kod' => '2011417',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak ranting kesat',
            'nama_saintifik' => 'Vatica odorata ',
            'kod' => '2011414',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Resak tempurong',
            'nama_saintifik' => 'Cotylelobium melanoxylon ',
            'kod' => '2011412',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Rukam',
            'nama_saintifik' => 'Flacourtia sp.',
            'kod' => '7350300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Saga',
            'nama_saintifik' => 'Adenanthera spp.',
            'kod' => '7450100',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'SAMAK',
            'nama_saintifik' => 'Ceriops sp.',
            'kod' => '4690300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Samak Pulut',
            'nama_saintifik' => 'Combretocarpus sp.',
            'kod' => '4690300',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sanggol lotong',
            'nama_saintifik' => 'Nephelium eriopetalum',
            'kod' => '7751301',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sebasah',
            'nama_saintifik' => 'Aporusa spp.',
            'kod' => '7330500',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'SENA',
            'nama_saintifik' => 'Pterocarpus indicus',
            'kod' => '7452301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sendudok hutan',
            'nama_saintifik' => 'Astronia spp.',
            'kod' => '7500100',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'SENGKUANG',
            'nama_saintifik' => 'Dracontomelon dao',
            'kod' => '7050501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sentang',
            'nama_saintifik' => 'Azadirachta excelsa',
            'kod' => '6510301',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sentul',
            'nama_saintifik' => 'Sandoricum koetjape',
            'kod' => '7511001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir',
            'nama_saintifik' => 'Sindora spp.',
            'kod' => '3452600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir beludu besar',
            'nama_saintifik' => 'Sindora velutina',
            'kod' => '3456004',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir daun nipis',
            'nama_saintifik' => 'Sindora echinocalyx',
            'kod' => '3456002',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir daun tebal',
            'nama_saintifik' => 'Sindora wallichii',
            'kod' => '3456005',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir lichin',
            'nama_saintifik' => 'Sindora coriaceae',
            'kod' => '3456001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepetir mempelas',
            'nama_saintifik' => 'Sindora siamensis',
            'kod' => '3456003',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sepul',
            'nama_saintifik' => 'Parishia spp.',
            'kod' => '7051000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'SEPUL',
            'nama_saintifik' => 'Parishia insignis',
            'kod' => '7051001',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sesenduk',
            'nama_saintifik' => 'Endospermum diadenum',
            'kod' => '8332400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Setumpul',
            'nama_saintifik' => 'Hydnocarpus spp.',
            'kod' => '7350600',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sial menahun',
            'nama_saintifik' => 'Pternandra spp.',
            'kod' => '8500300',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh',
            'nama_saintifik' => 'Dillenia spp.',
            'kod' => '4270000',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh ayer',
            'nama_saintifik' => 'Dillenia suffruticosa',
            'kod' => '4270108',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh beludu',
            'nama_saintifik' => 'Dillenia ovata',
            'kod' => '4270105',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh daun merah',
            'nama_saintifik' => 'Dillenia grandifolia',
            'kod' => '4270103',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh gajah',
            'nama_saintifik' => 'Dillenia reticulata',
            'kod' => '4270107',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh padang',
            'nama_saintifik' => 'Dillenia obovata',
            'kod' => '4270104',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh paya',
            'nama_saintifik' => 'Dillenia pulchella',
            'kod' => '4270106',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh putih',
            'nama_saintifik' => 'Dillenia albiflos',
            'kod' => '4270101',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Simpoh ungu',
            'nama_saintifik' => 'Dillenia excelsa',
            'kod' => '4270102',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Sukun',
            'nama_saintifik' => 'Artocarpus altilis',
            'kod' => '4530202',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Surian',
            'nama_saintifik' => 'Toona spp.',
            'kod' => '7511100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Surian batu',
            'nama_saintifik' => 'Chukrasia tabularis',
            'kod' => '7510501',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Surian bawang',
            'nama_saintifik' => 'Toona sinensis',
            'kod' => '7511101',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Surian wangi',
            'nama_saintifik' => 'Toona sureni',
            'kod' => '7511102',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Susun Pelepah',
            'nama_saintifik' => 'Aralia sp.',
            'kod' => '7000000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tapak Itik',
            'nama_saintifik' => 'Euodia sp.',
            'kod' => '7720600',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Teak',
            'nama_saintifik' => '-',
            'kod' => '-',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tembusu',
            'nama_saintifik' => 'Fagraeae spp.',
            'kod' => '6470100',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tembusu hutan',
            'nama_saintifik' => 'Fagraeae gigantea',
            'kod' => '6470102',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tembusu padang',
            'nama_saintifik' => 'Fagraeae fragrans',
            'kod' => '6470101',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tempinis',
            'nama_saintifik' => 'Streblus elongatus',
            'kod' => '7530700',
            'kumpulan_kayu_id' => 1,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terap',
            'nama_saintifik' => 'Artocarpus spp.',
            'kod' => '6530200',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terap hitam',
            'nama_saintifik' => 'Artocarpus scortechinii',
            'kod' => '6530215',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terap nasi',
            'nama_saintifik' => 'Artocarpus elasticus',
            'kod' => '6530204',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terentang',
            'nama_saintifik' => 'Campnosperma spp.',
            'kod' => '3050400',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terentang daun besar',
            'nama_saintifik' => 'Campnosperma auriculatum',
            'kod' => '3050401',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terentang daun kecil',
            'nama_saintifik' => 'Campnosperma squamatum',
            'kod' => '3050403',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Terentang simpoh',
            'nama_saintifik' => 'Campnosperma coriaceum',
            'kod' => '3050402',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tetiup',
            'nama_saintifik' => 'Adinandra spp.',
            'kod' => '8860100',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tinjau belukar',
            'nama_saintifik' => 'Proterandia spp.',
            'kod' => '8713600',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tongkat ali',
            'nama_saintifik' => 'Eurychoma longifolia',
            'kod' => '7800300',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tualang',
            'nama_saintifik' => 'Koompasia excelsa',
            'kod' => '4451301',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Tulang daing',
            'nama_saintifik' => 'Callerya atropurpurea',
            'kod' => '7451600',
            'kumpulan_kayu_id' => 2,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Ubah',
            'nama_saintifik' => 'Glochidion sp.',
            'kod' => '8333000',
            'kumpulan_kayu_id' => 3,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Walnut',
            'nama_saintifik' => 'Junglans',
            'kod' => '2089',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'White Ash',
            'nama_saintifik' => 'Fraxinus americana',
            'kod' => '2090',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'White Oak',
            'nama_saintifik' => 'Quercus alba',
            'kod' => '2091',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Yellow Birch',
            'nama_saintifik' => 'Betula alleghanieensis',
            'kod' => '2092',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );

        DB::table('spesis')-> insert(
            [

            'nama_tempatan' => 'Yellow Pine',
            'nama_saintifik' => 'Pinus ponderosa',
            'kod' => '2021',
            'kumpulan_kayu_id' => 5,
            'aktif' => 1,
            ]
        );


    }
}
