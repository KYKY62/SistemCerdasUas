<?php
class Fuzzy
{    
    protected $data;
    protected $rules;
    protected $nilai;
    protected $miu;
    protected $z;
    protected $luas;
    protected $total;
    protected $rank;

    function __construct()
    {
        $this->rules = $rules;    
    }

    function set_data($data){
        $this->data = $data;
    }

    function get_data(){
        return $this->data;
    }

    function hitung_nilai(){
        global $KRITERIA_HIMPUNAN, $KRITERIA;
    
        $arr = array();        
        //echo '<pre>' . print_r($data, 1) . '</pre>';                
        foreach($this->data as $key => $val){
            foreach($val as $k => $v){
                foreach($KRITERIA_HIMPUNAN[$k] as $a => $b){
                    $ba = $KRITERIA[$k]->batas_atas;
                    $bb = $KRITERIA[$k]->batas_bawah;
                    
                    $n1 = $b->n1;
                    $n2 = $b->n2;
                    $n3 = $b->n3;
                    $n4 = $b->n4;
                    
                    if($v<=$n1)
                        $nilai=0;
                    else if($v>=$n1 && $v<=$n2)
                        $nilai=($v-$n1)/($n2-$n1);
                    else if($v>=$n2 && $v<=$n3)
                        $nilai=1;
                    else if($v>=$n3 && $v<=$n4)
                        $nilai=($n4-$v)/($n4-$n3); 
                    else
                        $nilai=0;          
                    
                    if($v>=$ba && ($n3>=$ba || $n4>=$ba))
                        $nilai=1;
                        
                    if($v<=$bb && ($n1<=$bb || $n2<=$bb))
                        $nilai=1;
                            
                    $arr[$key][$k][$a] = $nilai;        
                }
            }
        }
        
        
        $this->nilai = $arr; 
    }

    function get_nilai(){        
        return $this->nilai;
    }

    function set_rules($rules){
        $this->rules = $rules;
    }

    function get_rules(){
        return $this->rules;
    }

    function hitung_miu(){
        $data = array();
        $arr = array();
        
        foreach ($this->nilai as $key => $val){        
            foreach($this->rules as $k => $v) {
                foreach($v->input as $a => $b){
                    $data[$k][$key][] = $val[$a][$b];
                }
            }
        }    
        
        foreach($data as $key => $val){
            foreach($val as $k => $v){
                //echo $this->rules[$key]->operator.'<br />';
                if($this->rules[$key]->operator=='AND')
                    $arr[$key][$k] = min($v);
                else
                    $arr[$key][$k] = max($v);
            }
        }
        $this->miu = $arr;        
    }

    function get_miu(){
        return $this->miu;
    }

    function hitung_z(){
        global $HIMPUNAN, $KRITERIA;

        foreach($this->rules as $no_aturan => $rule){
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

            foreach($this->miu[$no_aturan] as $key => $val){
                $z1 = $val*($n2-$n1) + $n1;
                $z2 = -$val*($n4-$n3) + $n4;
                $this->z[$no_aturan][$key] = array($z1, $z2);
            }
        }
    }

    function get_z(){
        return $this->z;
    }

    function hitung_total(){
        $arr = array();
        foreach($this->miu as $key => $val){
            foreach($val as $k => $v){
                $arr[$k][$key] = $v;
            }
        }
        $arr2 = array();
        foreach($arr as $key => $val){
            $maxs = array_keys($val, max($val));
            if($maxs[0]==0){
                $arr2[$key] = array();
            } else {
                $arr2[$key] = $this->z[$maxs[0]][$key];
            }            
        }
        foreach($arr2 as $key => $val){
            $this->total[$key] = array_sum($val) / count($val);
        }
        //echo '<pre>' . print_r($arr, 1) . '</pre>';
    }

    function get_total(){
        return $this->total;
    }

    function hitung_rank(){
        $data = $this->total;
        arsort($data);
        $no=1;
        $new = array();
        foreach($data as $key => $val){
            $new[$key] = $no++;
        }
        $this->rank = $new;
    }

    function get_rank(){
        return $this->rank;
    }
    
    function get_klasifikasi($val){
        global $ATRIBUT, $KRITERIA_HIMPUNAN, $KRITERIA, $HIMPUNAN;

        $key = key($ATRIBUT[1]);

        $arr = array();
        foreach($KRITERIA_HIMPUNAN[$key] as $a => $b){
            $ba = $KRITERIA[$key]->batas_atas;
            $bb = $KRITERIA[$key]->batas_bawah;
            
            $n1 = $b->n1;
            $n2 = $b->n2;
            $n3 = $b->n3;
            $n4 = $b->n4;
            
            if($val<=$n1)
                $nilai=0;
            else if($val>=$n1 && $val<=$n2)
                $nilai=($val-$n1)/($n2-$n1);
            else if($val>=$n2 && $val<=$n3)
                $nilai=1;
            else if($val>=$n3 && $val<=$n4)
                $nilai=($n4-$val)/($n4-$n3); 
            else
                $nilai=0;          
            
            if($val>=$ba && ($n3>=$ba || $n4>=$ba))
                $nilai=1;
                
            if($val<=$bb && ($n1<=$bb || $n2<=$bb))
                $nilai=1;

            $arr[$a] = $nilai;

        }

        arsort($arr);

        //echo '<pre>' . print_r($val, 1) . '</pre>';        

        return $HIMPUNAN[key($arr)]->nama_himpunan;
        
    }
}