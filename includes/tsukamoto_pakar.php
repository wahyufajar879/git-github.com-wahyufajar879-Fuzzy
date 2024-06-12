<?php
class TsukamotoPakar
{
    protected $data;
    protected $rules;
    protected $nilai;
    protected $miu;
    protected $z;
    protected $total;
    protected $rank;

    function __construct($rules, $data)
    {
        $this->rules = $rules;
        $this->data = $data;
    }

    function calculate()
    {
        $this->hitung_nilai();
        $this->hitung_miu();
        $this->hitung_z();
        $this->hitung_total();
    }

    function get_data()
    {
        return $this->data;
    }

    function hitung_nilai()
    {
        global $KRITERIA_HIMPUNAN, $KRITERIA;

        $arr = array();
        foreach ($this->data as $key => $val) {
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

                $arr[$key][$a] = $nilai;
            }
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';   
        $this->nilai = $arr;
    }

    function get_nilai()
    {
        return $this->nilai;
    }

    function get_rules()
    {
        return $this->rules;
    }

    function hitung_miu()
    {
        $data = array();
        $arr = array();
        foreach ($this->rules as $key => $val) {
            foreach ($val->input as $k => $v) {
                $data[$key][] = $this->nilai[$k][$v];
            }
        }
        foreach ($data as $key => $val) {
            if ($this->rules[$key]->operator == 'AND')
                $arr[$key] = min($val);
            else
                $arr[$key] = max($val);
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';   
        $this->miu = $arr;
    }

    function get_miu()
    {
        return $this->miu;
    }

    function hitung_z()
    {
        global $HIMPUNAN, $KRITERIA;

        foreach ($this->rules as $no_aturan => $rule) {
            $output = $rule->output;
            $kode_kriteria = key($output);
            $kode_himpunan = current($output);

            $ba = $KRITERIA[$kode_kriteria]->batas_atas;
            $bb = $KRITERIA[$kode_kriteria]->batas_bawah;

            $n1 = $HIMPUNAN[$kode_himpunan]->n1;
            $n2 = $HIMPUNAN[$kode_himpunan]->n2;
            $n3 = $HIMPUNAN[$kode_himpunan]->n3;
            $n4 = $HIMPUNAN[$kode_himpunan]->n4;

            //$a = ($z1 - $n1)/($n2-$n1);
            //$a*($n2-$n1) = $z-$n1;
            //$z1-$n1 = $a*($n2-$n1);
            //$z1 = $a*($n2-$n1) + $n1;

            //$a = ($n4-$z1)/($n4-$n3);
            //$a*($n4-$n3) = $n4-$z1;
            //$n4-$z1 = $a*($n4-$n3);
            //-$z1 = $a*($n4-$n3) - $n4;
            //$z1 = -$a*($n4-$n3) + $n4;


            $val = $this->miu[$no_aturan];
            $z = array();

            $zi = $val * ($n2 - $n1) + $n1;
            if ($val == 1 || $zi > $bb)
                $z[] = $zi;

            $zi = -$val * ($n4 - $n3) + $n4;
            if ($val == 1 || $zi < $ba)
                $z[] = $zi;

            $this->z[$no_aturan] = $z;
        }
    }

    function get_z()
    {
        return $this->z;
    }

    function hitung_total()
    {
        $arr = array();
        foreach ($this->miu as $key => $val) {
            if ($val > 0) {
                $z = $this->z[$key];
                $arr[$key] = array(
                    'a' => $val,
                    'az' => $val * array_sum($z) / count($z),
                );
            }
        }
        $az = array_sum(array_column($arr, 'az'));
        $a = array_sum(array_column($arr, 'a'));
        $this->total = $a ? $az / $a : 0;
        //echo '<pre>' . print_r($this->total, 1) . '</pre>';
    }

    function get_total()
    {
        return $this->total;
    }

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

        return $HIMPUNAN[key($arr)]->nama_himpunan;
        //echo '<pre>' . print_r(, 1) . '</pre>';        
    }
}
