<?php /*
Copyright (c) 2014 Trirand Ltd
If you want to obtain license for this product, go to http://www.guriddo.net
*/
${"GL\x4f\x42\x41LS"}["q\x68\x6f\x69\x6crxm\x71"]="\x69";${"\x47\x4c\x4f\x42\x41\x4cS"}["\x6ac\x64\x6e\x6bdv\x6f\x72\x67\x78"]="\x67\x4d";${"\x47\x4c\x4fB\x41\x4cS"}["\x6acwsc\x67h\x6a\x72\x73"]="s";${"GL\x4f\x42\x41\x4c\x53"}["\x6e\x62si\x66\x63a"]="p\x61\x67\x65\x72";${"\x47L\x4f\x42\x41L\x53"}["\x74\x68\x6e\x63\x64\x6b\x76\x69\x6f\x6c"]="t\x6d\x70\x70\x67";${"\x47\x4c\x4fB\x41LS"}["a\x6c\x6b\x65evq\x6e\x6a\x63"]="\x74\x62\x6c\x65\x6c\x65\x6de\x6et";${"G\x4cOB\x41\x4cS"}["\x79\x64\x73\x75\x68\x76z\x70\x6c"]="\x63\x72\x65\x61\x74\x65\x74b\x6c";${"\x47\x4cOB\x41L\x53"}["\x6b\x6f\x65c\x65\x63r\x74dxh"]="r\x65su\x6c\x74";${"\x47\x4cO\x42A\x4c\x53"}["\x78\x78\x65\x71q\x61"]="e\x63h\x6f";${"\x47\x4cO\x42\x41\x4cS"}["o\x6b\x64\x70\x73\x71\x6d\x6c\x6a"]="\x70\x61ra\x6d\x73";${"G\x4c\x4f\x42\x41L\x53"}["\x6at\x69\x64\x6a\x64\x79ngm"]="s\x71\x6c\x49\x64";${"\x47\x4cOB\x41\x4cS"}["\x71\x62\x69e\x68\x79\x63"]="sql";${"GLO\x42\x41LS"}["q\x78jd\x62\x75b\x6cf"]="g\x6f\x70\x65\x72";${"GL\x4fBA\x4cS"}["h\x63\x6d\x74\x79\x7a\x73ttrq"]="\x70a\x72\x61m";${"G\x4c\x4f\x42\x41\x4c\x53"}["\x77\x76e\x74\x6et\x71\x72\x6a\x77\x6b"]="\x61\x6fp\x74\x69\x6f\x6es";if(!defined("PHPS\x55\x49TO_\x52\x4f\x4f\x54")){define("P\x48\x50\x53UI\x54\x4f_R\x4fOT",dirname(__FILE__)."/");require(PHPSUITO_ROOT."\x41uto\x6c\x6f\x61\x64er.ph\x70");}class jqPivotGrid extends jqGridRender{private$pivotoptions=array('xDimension'=>array(),'yDimension'=>array(),'aggregates'=>array());private$ajaxoptions=array("data"=>array());private$data;public function setPivotOptions($aoptions){$suufxchilj="\x61\x6fptions";if(is_array(${$suufxchilj})){$this->pivotoptions=jqGridUtils::array_extend($this->pivotoptions,${${"\x47\x4cO\x42\x41\x4c\x53"}["\x77\x76\x65t\x6e\x74\x71\x72j\x77\x6b"]});}}public function setxDimension($param){${"G\x4cOB\x41\x4c\x53"}["g\x79\x62\x75\x61\x6d\x6f\x64pmu"]="\x70\x61\x72\x61\x6d";if(is_array(${${"\x47\x4cO\x42\x41\x4c\x53"}["gy\x62\x75a\x6do\x64p\x6d\x75"]})){$this->pivotoptions["xDi\x6dens\x69o\x6e"]=jqGridUtils::array_extend($this->pivotoptions["\x78\x44\x69mens\x69o\x6e"],${${"G\x4cO\x42\x41\x4cS"}["hc\x6d\x74\x79\x7as\x74\x74\x72\x71"]});}}public function setyDimension($param){if(is_array(${${"\x47\x4cOB\x41L\x53"}["\x68c\x6d\x74y\x7a\x73\x74\x74rq"]})){$this->pivotoptions["y\x44ime\x6e\x73\x69\x6fn"]=jqGridUtils::array_extend($this->pivotoptions["\x79\x44i\x6d\x65ns\x69\x6fn"],${${"GL\x4f\x42AL\x53"}["\x68\x63m\x74y\x7a\x73tt\x72q"]});}}public function setaggregates($param){if(is_array(${${"GL\x4f\x42AL\x53"}["\x68\x63\x6d\x74yz\x73t\x74\x72\x71"]})){$this->pivotoptions["\x61gg\x72ega\x74e\x73"]=jqGridUtils::array_extend($this->pivotoptions["\x61g\x67r\x65gate\x73"],${${"G\x4c\x4f\x42A\x4c\x53"}["h\x63\x6dt\x79\x7a\x73\x74\x74r\x71"]});}}public function setAjaxOptions($param){$xqfxffd="\x70ara\x6d";if(is_array(${$xqfxffd})){$vmjbgviban="\x70\x61\x72\x61\x6d";$this->ajaxoptions=jqGridUtils::array_extend($this->ajaxoptions,${$vmjbgviban});}}public function setData($mixdata){$pnfyxuq="mi\x78\x64\x61t\x61";$this->data=${$pnfyxuq};}public function renderPivot($tblelement='',$pager='',$script=true,array$params=null,$createtbl=false,$createpg=false,$echo=true){${"\x47\x4c\x4fBA\x4c\x53"}["\x6e\x71pb\x6bu\x63"]="\x67o\x70\x65r";${${"GLOB\x41\x4cS"}["\x6eq\x70\x62k\x75c"]}=$this->oper?$this->oper:"n\x6fo\x70e\x72";if(${${"G\x4c\x4fB\x41\x4cS"}["\x71\x78j\x64b\x75b\x6cf"]}=="p\x69v\x6f\x74"){$klwbfoo="\x73\x71l";${"\x47LOB\x41L\x53"}["\x74\x75w\x66\x67\x73\x77"]="\x72e\x74";${"\x47L\x4fBA\x4c\x53"}["v\x69\x77\x7a\x6f\x70\x76\x6e"]="\x73\x71l\x49\x64";${"\x47\x4c\x4f\x42\x41LS"}["\x71d\x6d\x6f\x63\x66\x6cuu"]="\x72et";${${"G\x4cO\x42AL\x53"}["\x71b\x69\x65hy\x63"]}=null;${${"GL\x4fBA\x4c\x53"}["\x76\x69wzopv\x6e"]}=$this->_setSQL();$this->dataType="json";${${"\x47\x4c\x4fB\x41\x4c\x53"}["\x71\x64\x6doc\x66lu\x75"]}=$this->execute(${${"G\x4c\x4f\x42\x41L\x53"}["\x6ati\x64j\x64\x79n\x67m"]},${${"G\x4c\x4f\x42A\x4cS"}["\x6fk\x64\x70s\x71ml\x6a"]},${$klwbfoo},false,0,0,"","");if(${${"\x47L\x4f\x42\x41\x4c\x53"}["\x74\x75\x77f\x67\x73\x77"]}){$qfvvmhzo="re\x73\x75\x6c\x74";$xgjhgohrdver="\x73\x71l";${$qfvvmhzo}=new stdClass();$result->rows=jqGridDB::fetch_object(${$xgjhgohrdver},true,$this->pdo);jqGridDB::closeCursor(${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x71b\x69\x65\x68\x79\x63"]});if(${${"\x47\x4c\x4f\x42\x41L\x53"}["\x78xe\x71q\x61"]}){$this->_gridResponse(${${"\x47\x4cO\x42\x41L\x53"}["\x6bo\x65\x63\x65\x63\x72\x74d\x78\x68"]});}else{$jwkpwpk="\x72e\x73\x75\x6c\x74";return${$jwkpwpk};}}else{echo"Co\x75\x6cd n\x6f\x74 \x65x\x65cut\x65 q\x75er\x79!\x21!";}}else{${"GL\x4fB\x41L\x53"}["\x71d\x76l\x6b\x72i"]="s";$this->setAjaxOptions(array("data"=>array("\x6f\x70er"=>"p\x69\x76ot")));${"\x47\x4c\x4f\x42\x41\x4c\x53"}["b\x6c\x6f\x75ks\x7a\x74"]="\x67\x4d";${${"\x47L\x4f\x42\x41L\x53"}["\x71d\x76\x6ckri"]}="";$tpxbxlrnelt="\x73\x63\x72i\x70\x74";$hrcwnsohvu="\x70\x61g\x65\x72";if(${${"GLOB\x41LS"}["y\x64\x73\x75h\x76zpl"]}){$elnbtahrxr="\x74\x6d\x70\x74\x62\x6c";${"G\x4cOBA\x4cS"}["\x6ce\x66\x76\x6bc"]="s";${"G\x4c\x4f\x42\x41\x4c\x53"}["k\x71b\x68\x76\x78\x71r\x66\x79\x61\x78"]="t\x62l\x65\x6c\x65\x6d\x65\x6et";${$elnbtahrxr}=${${"GL\x4f\x42AL\x53"}["\x61\x6c\x6be\x65\x76qnj\x63"]};${"\x47L\x4fB\x41\x4c\x53"}["q\x64\x64n\x74\x76b"]="tmp\x74b\x6c";if(strpos(${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["k\x71\x62\x68v\x78\x71\x72f\x79\x61x"]},"\x23")===false){${"\x47\x4c\x4f\x42A\x4c\x53"}["k\x61\x6dc\x64k\x6a"]="t\x62\x6cel\x65\x6de\x6e\x74";$dtzfmvqy="t\x62\x6ce\x6cem\x65\x6e\x74";${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x6bam\x63d\x6b\x6a"]}="\x23".${$dtzfmvqy};}else{$oookipp="\x74\x6d\x70\x74\x62\x6c";${$oookipp}=substr(${${"GL\x4f\x42\x41\x4cS"}["\x61\x6ck\x65\x65\x76\x71\x6e\x6a\x63"]},1);}${${"\x47\x4c\x4fB\x41LS"}["\x6c\x65f\x76\x6b\x63"]}.="\x3ctabl\x65\x20\x69\x64\x3d\x27".${${"\x47\x4cOB\x41L\x53"}["qd\x64n\x74v\x62"]}."'\x3e</\x74\x61bl\x65\x3e";}$fwmqbrcur="\x73c\x72\x69\x70t";${"\x47LO\x42\x41\x4c\x53"}["\x63\x74\x6c\x6fp\x64\x76\x6bcnr"]="\x70\x61\x67\x65\x72";if(strlen(${$hrcwnsohvu})>0){${"G\x4c\x4f\x42A\x4cS"}["t\x76\x6fkivh\x79rz"]="\x63r\x65\x61te\x70\x67";${${"\x47\x4cO\x42\x41\x4cS"}["\x74\x68n\x63\x64\x6b\x76\x69\x6f\x6c"]}=${${"\x47\x4c\x4f\x42\x41L\x53"}["n\x62\x73i\x66c\x61"]};${"\x47\x4c\x4fB\x41\x4c\x53"}["\x67\x72\x71y\x71\x75\x65"]="\x70\x61g\x65r";if(strpos(${${"\x47L\x4fBA\x4cS"}["\x67r\x71\x79qu\x65"]},"\x23")===false){${${"G\x4cOBA\x4c\x53"}["\x6e\x62si\x66ca"]}="\x23".${${"\x47\x4c\x4f\x42AL\x53"}["\x6e\x62si\x66\x63a"]};}else{${${"\x47\x4cO\x42A\x4cS"}["\x74h\x6ec\x64\x6bv\x69ol"]}=substr(${${"G\x4c\x4fB\x41L\x53"}["n\x62s\x69\x66\x63\x61"]},1);}if(${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x74\x76\x6fk\x69vhyr\x7a"]}){${"G\x4c\x4fB\x41L\x53"}["b\x78\x63\x67\x6b\x6ex\x6a"]="s";${${"GLO\x42\x41L\x53"}["\x62\x78\x63\x67k\x6ex\x6a"]}.="\x3c\x64i\x76 \x69d=\x27".${${"\x47L\x4f\x42\x41\x4cS"}["t\x68\x6e\x63\x64\x6b\x76\x69ol"]}."'\x3e\x3c/\x64iv>";}}${"\x47LO\x42\x41L\x53"}["r\x67p\x78\x64\x71\x6b\x65"]="\x73";if(strlen(${${"\x47\x4c\x4fBA\x4cS"}["\x6eb\x73i\x66c\x61"]})>0){$this->setGridOptions(array("\x70\x61ge\x72"=>${${"G\x4c\x4f\x42AL\x53"}["\x6eb\x73\x69fc\x61"]}));}if(${$fwmqbrcur}){${${"\x47\x4c\x4f\x42\x41L\x53"}["\x6a\x63\x77s\x63gh\x6ars"]}.="\x3csc\x72i\x70t\x20\x74yp\x65\x3d\x27\x74\x65xt/jav\x61sc\x72ipt\x27\x3e";${${"\x47\x4cO\x42\x41\x4c\x53"}["jcws\x63\x67\x68\x6a\x72s"]}.="\x6aQu\x65\x72\x79(\x64\x6f\x63u\x6d\x65\x6et).\x72ea\x64\x79(\x66u\x6ect\x69\x6f\x6e(\$) {";}${${"\x47L\x4fB\x41\x4c\x53"}["rg\x70\x78d\x71\x6b\x65"]}.="\x6a\x51\x75ery('".${${"G\x4cO\x42AL\x53"}["\x61\x6c\x6b\x65\x65\x76\x71\x6e\x6a\x63"]}."')\x2ej\x71\x47\x72id(\x27j\x71Pi\x76ot',".jqGridUtils::encode($this->data).",".jqGridUtils::encode($this->pivotoptions).",".jqGridUtils::encode($this->gridOptions).",".jqGridUtils::encode($this->ajaxoptions).");";if($this->navigator&&strlen(${${"\x47L\x4fBA\x4c\x53"}["\x63\x74\x6c\x6fpd\x76\x6b\x63nr"]})>0){${"GLO\x42\x41\x4cS"}["g\x73d\x6ci\x78"]="\x74b\x6c\x65leme\x6e\x74";$rpjfegvj="\x70\x61g\x65\x72";${"\x47\x4cOB\x41LS"}["w\x65\x66x\x68h\x75\x63\x6ay\x61"]="t\x62l\x65\x6c\x65\x6d\x65nt";$jtuuwmft="s";$rvsiontfhh="\x73";$this->setNavOptions("\x6e\x61vi\x67a\x74\x6fr",array("\x61dd"=>false,"\x65\x64it"=>false,"de\x6c"=>false));${$jtuuwmft}.="\x6aQu\x65\x72\x79('".${${"\x47\x4cOBA\x4c\x53"}["\x67\x73\x64\x6c\x69\x78"]}."\x27)\x2ebind(\x27\x6a\x71Gr\x69d\x49\x6ei\x74Gri\x64\x2ep\x69vot\x47\x72i\x64',(\x66\x75nction(){jQ\x75er\x79('".${${"GL\x4f\x42\x41\x4cS"}["\x77\x65\x66xhh\x75\x63\x6a\x79\x61"]}."').\x6a\x71\x47\x72id(\x27\x6e\x61\x76\x47r\x69\x64',\x27".${$rpjfegvj}."\x27,".jqGridUtils::encode($this->navOptions);${${"G\x4cO\x42\x41L\x53"}["\x6a\x63\x77\x73\x63\x67h\x6ar\x73"]}.=",{},{},{},".jqGridUtils::encode($this->searchOptions);${$rvsiontfhh}.=",".jqGridUtils::encode($this->viewOptions).")\x3b}));";}${${"\x47LO\x42A\x4c\x53"}["\x62\x6co\x75\x6b\x73\x7a\x74"]}=count($this->gridMethods);if(${${"\x47LOB\x41L\x53"}["\x6a\x63\x64\x6e\x6b\x64\x76o\x72g\x78"]}>0){$euuoonukcwie="\x67M";$erztfbl="\x69";for(${${"G\x4cOB\x41\x4cS"}["\x71h\x6fi\x6c\x72\x78\x6d\x71"]}=0;${$erztfbl}<${$euuoonukcwie};${${"\x47\x4cOB\x41\x4cS"}["\x71h\x6f\x69lrx\x6d\x71"]}++){${${"\x47\x4c\x4f\x42\x41\x4cS"}["j\x63\x77\x73\x63g\x68\x6a\x72s"]}.=$this->gridMethods[${${"\x47LOBAL\x53"}["\x71ho\x69\x6c\x72x\x6d\x71"]}]."\n";}}if(strlen($this->customCode)>0){${${"G\x4cO\x42\x41\x4c\x53"}["\x6a\x63\x77s\x63\x67\x68j\x72s"]}.=jqGridUtils::encode($this->customCode);}if(${$tpxbxlrnelt}){${${"GL\x4fB\x41\x4c\x53"}["j\x63w\x73\x63\x67\x68j\x72s"]}.="\x20});\x3c/s\x63r\x69\x70t\x3e";}if(${${"G\x4c\x4f\x42\x41\x4c\x53"}["x\x78eq\x71\x61"]}){echo${${"G\x4c\x4f\x42A\x4c\x53"}["\x6acw\x73\x63\x67h\x6a\x72s"]};}return${${"\x47\x4c\x4f\x42AL\x53"}["\x78\x78\x65\x71\x71\x61"]}?"":${${"\x47\x4cOB\x41L\x53"}["jc\x77\x73c\x67\x68\x6ar\x73"]};}}}
?>