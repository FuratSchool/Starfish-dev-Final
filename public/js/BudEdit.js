$('.editor').on('show.bs.modal', function (e) {
    var target = $(e.relatedTarget)[0].getAttribute('data-inputTarget');
   $(this).attr("targetInputID", target);
   var modalTitle = "Editor voor: "+$(target)[0].getAttribute('data-display');
   $('.modal-title b').text(modalTitle);
   var prevVal;
   if($(target)[0].hasAttributes("tmp")) {
       prevVal = $(target)[0].getAttribute("tmp")
   } else {
       prevVal = $(target).val();
   }
    $("#storyInput")[0].innerHTML = prevVal;
    $("#charCount").parent("p").css("font-size", "20px").removeClass("msg-danger-text").addClass("msg-success-text");
});

$('.editor').on('shown.bs.modal', function () {
    var len = 2000 - $("#storyInput").val().length;
    $('#charCount').text(len);
    $('#storyInput').focus();
});

$('.editor').on('hide.bs.modal', function () {
    var targetID = $(this).attr("targetInputID");
    var target = $(targetID);
    var content =  $('#storyInput')[0].innerHTML;
    target[0].setAttribute("tmp", content);
    content = "";
});

$("#storyInput").keyup(function(){
    var res = $("#storyInput").text();
    if(res.length >= 2000) {
        $("#charCount").parent("p").css("font-size", "20px").removeClass("msg-success-text").addClass("msg-danger-text");
        $("#charWarning").text("Let op! te veel tekens!   ");
    }
    if(res.length < 2000) {
        $("#charCount").parent("p").css("font-size", "20px").removeClass("msg-danger-text").addClass("msg-success-text");
        $("#charWarning").text("");
    }
    $("#charCount").text(2000 - res.length);
});

function getSelectedText() {
    var selectedText = "", sel;
    if (window.getSelection) {
        selectedText = "" + window.getSelection();
    } else if ( (sel = document.selection) && sel.type === "Text") {
        selectedText = sel.createRange().text;
    }
    return selectedText;
}

function insert(before, after) {
    var sel;
    var html = before + getSelectedText() + after;
    if ( (sel = document.selection) && sel.type !== "Control") {
        var range = sel.createRange();
        range.parseHTML(html);
    } else {
        document.execCommand("InsertHTML", false, html);
    }
}

$("button[id^=heading]").click(function () {
        var size = $(this).attr("id").substr(-1);
        var open = "<h"+size+">";
        var close = "</h"+size+">";
        insert(open, close);
});

$("button#insertParagraph").click(function () {
    const open = "<p><br>";
    const close = "<br></p>";
    insert(open, close);
});

$("button#insertLine").click(function () {
    const open = "<hr contenteditable='false' style='border: solid 2px black'><br>";
    const close = "";
    insert(open, close);
});

$("button[id^=style]").click(function() {
    var styling = $(this).attr("id").substring(5).toLowerCase();
    var el = window.getSelection().focusNode;
    insert('<span>', '</span>');
    el = window.getSelection().focusNode;
    var parent = el.parentNode;
    console.log(parent);
    if(parent.localName === "p" || parent.localName.charAt(0) === "h" || parent.localName === "span") {
        if(styling === "underlined" && parent.classList.contains("text-strikethrough")|| styling === "strikethrough" && parent.classList.contains("text-underlined")) {
            parent.classList.remove("text-underlined", "text-strikethrough");
            styling = "understrike";
        } else if ((styling === "underlined" || styling === "strikethrough" ) && parent.classList.contains("text-understrike")) {
            parent.classList.remove("text-understrike");
            switch (styling) {
                case "underlined":
                    styling = "strikethrough";
                    break;
                case "strikethrough":
                    styling = "underlined";
                    break;
            }
        }
        parent.classList.toggle("text-"+styling);
    } else if (el.localName === "p" || el.localName.charAt(0) === "h" || el.localName === "span") {
        if(styling === "underlined" && el.classList.contains("text-strikethrough")|| styling === "strikethrough" && el.classList.contains("text-underlined")) {
            el.classList.remove("text-underlined", "text-strikethrough");
            styling = "understrike";
        } else if ((styling === "underlined" || styling === "strikethrough" ) && el.classList.contains("text-understrike")) {
            el.classList.remove("text-understrike");
            switch (styling) {
                case "underlined":
                    styling = "strikethrough";
                    break;
                case "strikethrough":
                    styling = "underlined";
                    break;
            }
        }
        el.classList.toggle("text-"+styling);
    } else {
        var open = "<span class='text-'"+styling+">";
        var close = "</span>";
        insert(open, close);
    }
});

$("button[id^=text]").click(function() {
    var alignment = $(this).attr('id').substring(4).toLowerCase();
    var el = window.getSelection().focusNode;
    var parent = el.parentNode;
    if(parent.localName === "p" || parent.localName.charAt(0) === "h") {
        parent.classList.remove("text-left", "text-center", "text-right", "text-justify");
        parent.classList.add("text-"+alignment);

    } else if (el.localName === "p" || el.localName.charAt(0) === "h") {
        el.classList.remove("text-left", "text-center", "text-right", "text-justify");
        el.classList.add("text-"+alignment);

    } else {
            var open = "<p class='text-'"+alignment+">";
            var close = "</p>";
            insert(open, close);
    }
});

$("button[id^=list]").click(function() {
    const ul_open = "<ul>";
    const ul_close = "</ul>";
    const ol_open = "<ol>";
    const ol_close = "</ol>";
    const li_open = "<li>";
    const li_close = "</li>";
    var listaction =  $(this).attr('id').substring(4).toLowerCase();
    switch (listaction) {
        case "ordered":
                open = ol_open + "\n"+li_open;
                close = li_close+"\n"+ol_close;
            break;
        case "unordered":
                open = ul_open + "\n"+li_open;
                close = li_close+"\n"+ul_close;
            break;
        case  "indent":
           indent();
           return;
        case "outdent":
            outdent();
            return;
    }
    insert(open, close);
});

function indent() {
    var el = window.getSelection().focusNode;
    if(el.localName === "li") {
         var parent = el.parentNode;
         ltype = parent.localName;
        switch (ltype) {
            case "ul":
                 ul = document.createElement("ul");
                 li = document.createElement("li");
                 sibling = el.previousSibling;
                if(sibling !== null && sibling.localName === "ul") {
                    parent.removeChild(el);
                    sibling.appendChild(li);
                } else {
                    ul.appendChild(li);
                    parent.replaceChild(ul, el);
                }
                return;
            case "ol":
                 ol = document.createElement("ol");
                 li = document.createElement("li");
                 sibling = el.previousSibling;
                if(sibling !== null && sibling.localName === "ol") {
                    parent.removeChild(el);
                    sibling.appendChild(li);
                } else {
                    ol.appendChild(li);
                    parent.replaceChild(ol, el);
                }
                return;
        }
    } else if (el.nodeName === "#text" && el.parentNode.localName === "li"){
        var item = el.parentNode;
         parent = item.parentNode;
         ltype = parent.localName;
        switch (ltype) {
            case "ul":
                 ul = document.createElement("ul");
                 li = document.createElement("li");
                 node = document.createTextNode(item.innerText);
                li.appendChild(node);
                 sibling = item.previousSibling;
                if(sibling !== null && sibling.localName === "ol") {
                    parent.removeChild(item);
                    sibling.appendChild(li)
                } else {
                    ul.appendChild(li);
                    parent.replaceChild(ul, item);
                }
                return;
            case "ol":
                 ol = document.createElement("ol");
                 li = document.createElement("li");
                 node = document.createTextNode(item.innerText);
                li.appendChild(node);
                 sibling = item.previousSibling;
                if(sibling !== null && sibling.localName === "ol") {
                    parent.removeChild(item);
                    sibling.appendChild(li)
                } else {
                    ol.appendChild(li);
                    parent.replaceChild(ol, item);
                }
                return;
        }

    } else {

    }
}

function outdent() {
    var el = window.getSelection().focusNode;
    if(el.localName === "li") {
         parent = el.parentNode;
         superparent = parent.parentNode;
        if(superparent.localName === "div") {

        } else {
             li = document.createElement("li");
            if(parent.childNodes.length > 1) {
                parent.removeChild(el);
                 sibling = parent.nextSibling;

                if(sibling === null) {
                    superparent.appendChild(li)
                } else {
                    superparent.insertBefore(li, sibling)
                }
            } else {
                superparent.replaceChild(li, parent);
            }
        }
    } else if (el.nodeName === "#text" && el.parentNode.localName === "li") {
        var item = el.parentNode;
         var parent = item.parentNode;
         superparent = parent.parentNode;
        if(superparent.localName === "div") {

        } else {
                 li = document.createElement("li");
                var node = document.createTextNode(item.innerText);
                li.appendChild(node);
            if(parent.childNodes.length > 1) {
                parent.removeChild(item);
                 sibling = superparent.nextSibling;
                if(sibling === null) {
                    superparent.appendChild(li)
                } else {
                    parent.insertBefore(li, sibling)
                }
            } else {
                superparent.replaceChild(li, parent);
            }
        }
    } else {

    }
}

$("button#createLink").click(function(){
        var location = prompt('Waar wilt u naar toe linken?');
         var open = '<a href="'+location+'">';
         var close = '</a>';
        insert(open, close);
});

$('button#contentSave').click(function(){
    var content = $("#storyInput")[0].innerHTML;
    var targetID = $(".editor")[0].getAttribute('targetinputid');
    var target = $(targetID);
    target.val(content);
    $('.editor').modal('hide');
});

$('button#clearContent').click(function(){
  $("#storyInput")[0].innerHTML = '';
    var targetID = $(".editor")[0].getAttribute('targetinputid');
    var target = $(targetID);
    target.val('');
    target[0].setAttribute('tmp', '');

});
var keyCodes = {
    9 : true,
    66 : true,
    73 : true,
    80 : true,
    69 : true,
    76 : true,
    82 : true,
    74 : true,
    49 : true,
    50 : true,
    51 : true,
    52 : true,
    53 : true,
    54 : true,
    79 : true,
    85 : true,
    75 : true,
    77 :  true
};
$(".editor").keydown(function(e){
    if(e.keyCode === 9) {
        e.preventDefault();
        if(!e.shiftKey) {
            indent();
        } else if(e.shiftKey) {
            outdent();
        }
    }
    if(keyCodes[e.keyCode] && e.ctrlKey) {
        e.preventDefault();
        if(e.keyCode === 66) {
            $('button#styleBold').click();
        } else if(e.keyCode === 73) {
            $('button#styleItalic').click();
        } else if(e.keyCode === 85) {
            $('button#styleUnderlined').click();
        } else if(e.keyCode === 80) {
            $('button#insertParagraph').click();
        } else if(e.keyCode === 69) {
            $('button#textCenter').click();
        } else if(e.keyCode === 76) {
            $('button#textLeft').click();
        } else if(e.keyCode === 82) {
            $('button#textRight').click();
        } else if(e.keyCode === 74) {
            $('button#textJustify').click();
        } else if(e.keyCode === 49 && e.shiftKey) {
            $('button#heading1').click();
        } else if(e.keyCode === 50 && e.shiftKey) {
            $('button#heading2').click();
        } else if(e.keyCode === 51 && e.shiftKey) {
            $('button#heading3').click();
        } else if(e.keyCode === 52 && e.shiftKey) {
            $('button#heading4').click();
        } else if(e.keyCode === 53 && e.shiftKey) {
            $('button#heading5').click();
        } else if(e.keyCode === 54 && e.shiftKey) {
            $('button#heading6').click();
        } else if(e.keyCode === 79) {
            $('button#listOrdered').click();
        } else if(e.keyCode === 77) {
            $('button#listUnordered').click();
        }
    }
});