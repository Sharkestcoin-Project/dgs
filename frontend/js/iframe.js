"use strict";
window.addEventListener("load", function(){
    iframe();
});


function iframe() {
    // Get the modal
    var ebModal = document.getElementById('mySizeChartModal');

    // Get the button that opens the modal
    var ebBtn = document.getElementById("mySizeChart");

    // Get the <span> element that closes the modal
    var ebSpan = document.getElementsByClassName("ebcf_close")[0];

    // When the user clicks the button, open the modal
    ebBtn.onclick = function() {
        ebModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    ebSpan.onclick = function() {
        ebModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == ebModal) {
            ebModal.style.display = "none";
        }
    }

    // CSS
    var ebModalCss = {display:'none',position:'fixed',zIndex:900,paddingTop:'50px',left:0,top:0,width:'100%',minHeight:'100%',overflow:'auto',backgroundColor:'rgb(0,0,0)',backgroundColor:'rgba(0,0,0,0.4)'};
    Object.assign(ebModal.style, ebModalCss);

    var ebBtnCss = {borderRadius: '5px', textDecoration: 'none', padding: '10px 20px', background: '#007bff', color: '#FFF'};
    Object.assign(ebBtn.style, ebBtnCss);

    var ebSpan_css = {color:'#aaaaaa',float:'right',fontSize:'28px',fontWeight:'bold',cursor:'pointer'};
    Object.assign(ebSpan.style, ebSpan_css);

    var ebcf_modal_content = document.getElementById('ebcf_modal_content');
    var ebcf_modal_content_css = {padding:'20px',height:'420px',backgroundColor:'#fefefe',margin:'auto',border:'1px solid #888'};
    Object.assign(ebcf_modal_content.style, ebcf_modal_content_css);

    if (window.innerWidth > 700) {
        ebcf_modal_content.style.width = '35%'
    } else {
        ebcf_modal_content.style.width = '85%'
    }
}
