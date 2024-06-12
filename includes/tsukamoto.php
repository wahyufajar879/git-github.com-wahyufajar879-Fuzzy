<?php

function generate_aturan()
{
    global $KRITERIA_HIMPUNAN;
    end($KRITERIA_HIMPUNAN);
    $kode_target = key($KRITERIA_HIMPUNAN);

    $arr = $KRITERIA_HIMPUNAN;
    array_pop($arr);

    $a = 0;
    $aturan = array();
    foreach ($arr as $key => $val) {
        $aturan = _generate_aturan($aturan, $key, $val);
    }

    $val_target = $KRITERIA_HIMPUNAN[$kode_target];

    $fields = array();
    foreach ($aturan as $key => $val) {
        $val[$kode_target] = array_rand($val_target);
        foreach ($val as $k => $v) {
            $fields[] = array(
                'no_aturan' => $key + 1,
                'kode_kriteria' => $k,
                'kode_himpunan' => $v,
                'operator' => 'AND',
            );
        }
    }
    global $db;
    $db->multi_query('tb_aturan', $fields);
    //echo '<pre>' . print_r($aturan, 1) . '</pre>';
}
function _generate_aturan($aturan, $key, $val)
{
    if ($aturan) {
        $arr  = array();
        foreach ($aturan as $k => $v) {
            foreach ($val as $a => $b) {
                $v[$key] = $a;
                $arr[] = $v;
            }
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';
        return $arr;
    }
    $arr  = array();
    foreach ($val as $k => $v) {
        $arr[] = array($key => $k);
    }
    //echo '<pre>' . print_r($arr, 1) . '</pre>';
    return $arr;
}
class Fuzzy
{
    /**
     * data nilai alternatif
     **/
    protected $data;
    /**
     * data aturan
     **/
    protected $rules;
    /**
     * nilai fuzzy
     **/
    protected $nilai;
    /**
     * nilai a*z
     **/
    protected $alfa_z;
    /**
     * nilai miu
     **/
    protected $miu;
    /**
     * nilai z
     **/
    protected $z;
    /**
     * hasil defuzzyfikasi
     **/
    protected $total;
    /**
     * hasil perangkingan
     **/
    protected $rank;

    /**
     * konstruktor
     * @param $rules int Basis aturan
     * @param $data  int Data nilai alternatif
     **/
    function __construct($rules, $data)
    {
        $this->rules = $rules;
        $this->data = $data;
    }
    /**
     * Melakukan proses perhitungan fuzzy
     **/
    function calculate()
    {
        $this->hitung_nilai();
        $this->hitung_miu();
        $this->hitung_z();
        $this->hitung_total();
        $this->hitung_rank();
        $this->hitung_alfa_z();
    }
    function hitung_alfa_z()
    {
        $alfa_z = array();
        foreach ($this->miu as $key => $miu_per_rule) {
            foreach ($miu_per_rule as $index => $miu_value) {
                $alfa = $miu_value; // Menggunakan nilai miu sebagai nilai alfa
                $z_value = $this->z[$key][$index][0]; // Mendapatkan nilai z pertama dari aturan
                $alfa_z[$key][$index] = $alfa * $z_value; // Hitung alfa * z
            }
        }
        $this->alfa_z = $alfa_z;
    }
    
function get_alfaZ()
{
    return $this->alfa_z;
}
    /**
     * Mengambil data
     * @return   array   $data
     **/
    function get_data()
    {
        return $this->data;
    }
    /**
     * Menghitung nilai fuzzy masing-masing alternatif    
     **/
    function hitung_nilai()
    {
        global $KRITERIA_HIMPUNAN, $KRITERIA;

        $arr = array();
        //echo '<pre>' . print_r($this->data, 1) . '</pre>';                
        foreach ($this->data as $key => $val) { // mengulang sebanyak baris data
            foreach ($val as $k => $v) { //mengulang sebanyak kolom data
                foreach ($KRITERIA_HIMPUNAN[$k] as $a => $b) { //mengulang sebanyak himpunan fuzzy
                    $ba = $KRITERIA[$k]->batas_atas;
                    $bb = $KRITERIA[$k]->batas_bawah;

                    $n1 = $b->n1;
                    $n2 = $b->n2;
                    $n3 = $b->n3;
                    $n4 = $b->n4;

                    if ($v <= $n1) //jika di bawah trapesium
                        $nilai = 0;
                    else if ($v >= $n1 && $v <= $n2) //jika pada daerah trapesium naik
                        $nilai = ($v - $n1) / ($n2 - $n1);
                    else if ($v >= $n2 && $v <= $n3) //jika pada daerah trapesum atas
                        $nilai = 1;
                    else if ($v >= $n3 && $v <= $n4) //jika pada daerah trapesium turun
                        $nilai = ($n4 - $v) / ($n4 - $n3);
                    else //jika lebih dari trapesium
                        $nilai = 0;

                    if ($v >= $ba && ($n3 >= $ba || $n4 >= $ba)) //jika melebihi batas atas
                        $nilai = 1;

                    if ($v <= $bb && ($n1 <= $bb || $n2 <= $bb)) //jika melebihi batas bawah
                        $nilai = 1;

                    $arr[$key][$k][$a] = $nilai;
                }
            }
        }


        $this->nilai = $arr;
    }
    /**
     * Mengambil nilai fuzzy
     * @return   array Data nilai fuzzy
     **/
    function get_nilai()
    {
        return $this->nilai;
    }
    /**
     * Mengambil rules
     * @return   array Data rules
     **/
    function get_rules()
    {
        return $this->rules;
    }
    /**
     * Melakukan perhitungan miu    
     **/
    function hitung_miu()
    {
        $data = array();
        $arr = array();

        /**
         * Mengelompokkan nilai miu
         */
        foreach ($this->nilai as $key => $val) {
            foreach ($this->rules as $k => $v) {
                foreach ($v->input as $a => $b) {
                    $data[$k][$key][] = $val[$a][$b];
                }
            }
        }
        /**
         * Mencari nilai miu
         */
        foreach ($data as $key => $val) {
            foreach ($val as $k => $v) {
                //echo $this->rules[$key]->operator.'<br />';
                if ($this->rules[$key]->operator == 'AND') //jika operator AND maka dicari nilai terkecil
                    $arr[$key][$k] = min($v);
                else  //jika operator OR maka dicari nilai terbesar
                    $arr[$key][$k] = max($v);
            }
        }
        $this->miu = $arr;  
    }
    
    /**
     * Mengambil nilai miu
     * @return   array Data nilai miu
     **/
    function get_miu()
    {
        return $this->miu;
    }
    /**
     * Mengambil nilai z    
     **/
   /**
 * Menghitung nilai z berdasarkan metode fuzzy Tsukamoto
 **/
/**
 * Menghitung nilai z berdasarkan metode fuzzy Tsukamoto
 **/
/**
 * Menghitung nilai z berdasarkan metode fuzzy Tsukamoto
 **/
function hitung_z()
{
    global $HIMPUNAN, $KRITERIA;

    foreach ($this->rules as $no_aturan => $rule) {
        $output = $rule->output;
        $kode_kriteria = key($output);
        $kode_himpunan = current($output);

        /**
         * Batas bawah dan batas atas
         */
        $ba = $KRITERIA[$kode_kriteria]->batas_atas;
        $bb = $KRITERIA[$kode_kriteria]->batas_bawah;

        /**
         * Titik-titik pada trapesium
         */
        $n1 = $HIMPUNAN[$kode_himpunan]->n1;
        $n2 = $HIMPUNAN[$kode_himpunan]->n2;
        $n3 = $HIMPUNAN[$kode_himpunan]->n3;
        $n4 = $HIMPUNAN[$kode_himpunan]->n4;

        /**
         * Mencari nilai z
         */
        foreach ($this->miu[$no_aturan] as $key => $val) {
            $z = array();

            /**
             * Untuk yang trapesium naik
             */
            $zi_naik = $val * ($n2 - $n1) + $n1;

            if ($val == 1 || $zi_naik <= $n2) {
                $z[] = $zi_naik;
            }

            /**
             * Mencari yang trapesium turun
             */
            $zi_turun = -$val * ($n4 - $n3) + $n4;

            if ($val == 1 || $zi_turun >= $n3) {
                $z[] = $zi_turun;
            }

            // Simpan nilai z yang dihitung
            $this->z[$no_aturan][$key] = $z;

            // Display all calculated z values
            // echo "Calculated Z values: " . implode(", ", $z) . "\n\n";
        }
    }
}



    /**
     * Mengambil nilai z
     * @return   array Data nilai z
     **/
    function get_z()
    {
        return $this->z;
    }
    /**
     * Mengambil nilai total    
     **/
    /**
 * Menghitung nilai total menggunakan defuzzifikasi dengan rumus jumlah (a * z) / jumlah a
 **/
function hitung_total() {
    $arr = array();
    foreach ($this->miu as $rule_index => $miu_values) {
        foreach ($miu_values as $data_index => $miu_value) {
            if ($miu_value > 0) {
                $z_values = $this->z[$rule_index][$data_index];
                if (!isset($arr[$data_index])) {
                    $arr[$data_index] = array(
                        'az' => 0,
                        'a' => 0,
                    );
                }

                // Menampilkan nilai miu dan z
                // echo "Rule $rule_index, Data $data_index, Miu: $miu_value<br>";
                // echo "Nilai z untuk rule $rule_index, data $data_index: " . implode(", ", $z_values) . "<br>";

                $az = $miu_value * $z_values[0]; // Mengambil nilai z pertama
                $a = $miu_value;

                // // Menampilkan perhitungan az dan a
                // echo "Perhitungan az untuk rule $rule_index, data $data_index: $miu_value * {$z_values[0]} = $az<br>";
                // echo "Nilai a untuk rule $rule_index, data $data_index: $a<br>";

                $arr[$data_index]['az'] += $az;
                $arr[$data_index]['a'] += $a;

                // Menampilkan nilai akumulasi az dan a
                // echo "Akumulasi az untuk data $data_index: {$arr[$data_index]['az']}<br>";
                // echo "Akumulasi a untuk data $data_index: {$arr[$data_index]['a']}<br>";
            }
        }
    }

    foreach ($arr as $data_index => $val) {
        $az = $val['az'];
        $a = $val['a'];
        $this->total[$data_index] = $a ? $az / $a : 0;

        // Menampilkan hasil perhitungan total
        // echo "Hasil total untuk data $data_index: {$this->total[$data_index]}<br>";
    }
}
function get_sum_miu() {
    $sum_miu = array();
    foreach ($this->miu as $rule_index => $miu_values) {
        foreach ($miu_values as $data_index => $miu_value) {
            if (!isset($sum_miu[$data_index])) {
                $sum_miu[$data_index] = 0;
            }
            $sum_miu[$data_index] += $miu_value;
        }
    }
    return $sum_miu;
}

/**
 * Menghitung akumulasi az per alternatif
 * @return array Akumulasi az per alternatif
 **/
function get_sum_az() {
    $sum_az = array();
    foreach ($this->miu as $rule_index => $miu_values) {
        foreach ($miu_values as $data_index => $miu_value) {
            if ($miu_value > 0) {
                $z_values = $this->z[$rule_index][$data_index];
                if (!isset($sum_az[$data_index])) {
                    $sum_az[$data_index] = 0;
                }
                $sum_az[$data_index] += $miu_value * $z_values[0]; // Menggunakan nilai z pertama
            }
        }
    }
    return $sum_az;
}



/**
 * Mengambil nilai total
 * @return   array Data nilai total
 **/
function get_total()
{
    return $this->total;
    
}

    /**
     * Mengambil rank
     * @return   array Data rank
     **/
    function hitung_rank()
    {
        $data = $this->total;
        arsort($data); //mengurutkan data dari besar ke kecil dengan tetap mempertahankan key array
        $no = 1;
        $new = array();
        foreach ($data as $key => $val) {
            $new[$key] = $no++;
        }
        $this->rank = $new;
    }
    /**
     * Mengambil data rank        
     * @return  array
     */
    function get_rank()
    {
        return $this->rank;
    }
    /**
     * Mencari klasifikasi himpunan berdasarkan total nilai    
     * @param   int     $val Total nilai    
     * @return  array
     */
    function get_klasifikasi($val)
    {
        global $ATRIBUT, $KRITERIA_HIMPUNAN, $KRITERIA, $HIMPUNAN;

        $key = key($ATRIBUT[1]);

        $arr = array();
        foreach ($KRITERIA_HIMPUNAN[$key] as $a => $b) {
            $ba = $KRITERIA[$key]->batas_atas;
            $bb = $KRITERIA[$key]->batas_bawah;

            $n1 = $b->n1;
            $n2 = $b->n2;
            $n3 = $b->n3;
            $n4 = $b->n4;

            if ($val <= $n1)
                $nilai = 0;
            else if ($val >= $n1 && $val <= $n2)
                $nilai = ($val - $n1) / ($n2 - $n1);
            else if ($val >= $n2 && $val <= $n3)
                $nilai = 1;
            else if ($val >= $n3 && $val <= $n4)
                $nilai = ($n4 - $val) / ($n4 - $n3);
            else
                $nilai = 0;

            if ($val >= $ba && ($n3 >= $ba || $n4 >= $ba))
                $nilai = 1;

            if ($val <= $bb && ($n1 <= $bb || $n2 <= $bb))
                $nilai = 1;

            $arr[$a] = $nilai;
        }

        arsort($arr);

        //echo '<pre>' . print_r($val, 1) . '</pre>';        

        return $HIMPUNAN[key($arr)]->nama_himpunan;
    }
}

class Rule
{
    public $no_aturan;
    public $operator;
    public $input;
    public $output;

    function __construct($rows)
    {
        $dicari = get_dicari();
        foreach ($rows as $row) {
            $this->no_aturan = $row->no_aturan;
            $this->operator = $row->operator;

            if ($row->kode_kriteria == $dicari) {
                $this->output[$row->kode_kriteria] = $row->kode_himpunan;
            } else {
                $this->input[$row->kode_kriteria] = $row->kode_himpunan;
            }
        }
    }

    function to_string()
    {
        global $HIMPUNAN, $KRITERIA;
        $str = 'IF';
        $arr = array();
        foreach ($this->input as $key => $val) {
            $arr[] = '<code>' . $KRITERIA[$key]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[$val]->nama_himpunan . '</code>';
        }
        $str .= ' ' . implode(' ' . $this->operator . ' ', $arr);
        $str .= ' THEN <code>' . $KRITERIA[key($this->output)]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[current($this->output)]->nama_himpunan . '</code>';

        return $str;
    }
}
