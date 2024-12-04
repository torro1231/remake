Install databasenya db_pegawai
buat database db_pegawai
eksekusi query pada file db_pegawai.sql (bisa diimport atau eksekusi query/tab SQL pada phpmyadmin)

Edit koneksi ke database
edit file config/koneksi.php, sesuaikan nama host, username dan password database 

Username & Password
Type         	Username	Password      
Admin 		andez  		andez
Admin Pegawai	wahyu		wahyu
Admin Absen	rohmah		rohmah
User		asep		asep


Bila eror ketika import db_pegawai pada view tabel maka lakukan manual pada phpmyadmin dibagian SQL masukan 
query ini : 




create view absensi_v as ( select id_absensi,absensi.id_ijin,d.nm_ijin,absensi.nip,b.nama,tanggal_absen,c.shift,jam_in,c.jam_masuk,jam_out,c.jam_pulang, TIMESTAMPDIFF(HOUR,c.jam_pulang,jam_out)as lembur_jam,TIMEDIFF(jam_out,c.jam_pulang)as lembur,status_masuk,status_keluar,terlambat,pulangcepat,ket,TIMEDIFF(jam_in,c.jam_masuk)as jam_telat, TIMEDIFF(c.jam_pulang,jam_out)as jam_p_cepat from absensi LEFT JOIN pegawai b ON absensi.nip = b.nip LEFT JOIN tbl_absen c ON absensi.id_abs = c.id_abs LEFT JOIN tbl_ijin d ON absensi.id_ijin=d.id_ijin order by absensi.tanggal_absen desc)


create view ajuancuti_v as (SELECT ajuancuti.kdcuti,pegawai.nip,pegawai.nama,ajuancuti.tgl_pengajuan,tbl_cuti.n_cuti,ajuancuti.tgl_mulai,ajuancuti.tgl_akhir,ajuancuti.lama_cuti,status_app.approve FROM ajuancuti
left join pegawai ON ajuancuti.id=pegawai.id
left join tbl_cuti ON ajuancuti.id_cuti=tbl_cuti.id_cuti
left join status_app ON ajuancuti.kd_approve=status_app.kd_approve
ORDER BY ajuancuti.tgl_pengajuan ASC)


create view m_kerja as (
select pegawai.nip AS nip,pegawai.nama AS nama,pegawai.tgl_masuk AS tgl_masuk,(year(curdate()) - year(pegawai.tgl_masuk)) AS t_mk from pegawai order by (year(curdate()) - year(pegawai.tgl_masuk)) desc
)


create view pensiun_jf as (
select a.id AS id,a.nip AS nip,a.nama AS nama,a.foto AS foto,a.tgl_lahir AS tgl_lahir,b.t_lahir AS t_lahir,a.id_stsk AS id_stsk,c.nm_jbfungsi AS nm_jbfungsi,c.t_pensiun AS t_pensiun,(c.t_pensiun - b.t_lahir) AS a_pensiun from ((pegawai a join umur_p b) join jb_fungsi c) where ((a.nip = b.nip) and (a.kd_jbfungsi = c.kd_jbfungsi) and (a.id_stsk = 1))) 



create view umur_p AS (select pegawai.nip AS nip,pegawai.nama AS nama,pegawai.tgl_lahir AS tgl_lahir,(year(curdate()) - year(pegawai.tgl_lahir)) AS t_lahir from pegawai order by (year(curdate()) - year(pegawai.tgl_lahir)) desc)



create view sisa_kontrak_v as (SELECT a.id,a.nip,a.nama,a.foto,datediff(a.tgl_kontrak,current_date()) as sisa,a.tgl_kontrak,b.username from pegawai a 
left join tbl_user b on a.id=b.id)
