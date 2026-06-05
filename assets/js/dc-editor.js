(function () {
  'use strict';

  /* ── Editor helpers ── */

  function getEditor() {
    var id = window.DC_EDITOR_ID || 'dc-editor';
    return document.getElementById(id);
  }

  function fmt(cmd, val) {
    var editor = getEditor();
    if (!editor) return;
    editor.focus();
    document.execCommand(cmd, false, val || null);
  }

  function insertAtCursor(html) {
    var editor = getEditor();
    if (!editor) return;
    editor.focus();
    var sel = window.getSelection();
    if (!sel.rangeCount) return;
    var range = sel.getRangeAt(0);
    range.deleteContents();
    var div = document.createElement('div');
    div.innerHTML = html;
    var frag = document.createDocumentFragment();
    var lastNode;
    while (div.firstChild) {
      lastNode = div.firstChild;
      frag.appendChild(div.firstChild);
    }
    range.insertNode(frag);
    if (lastNode) {
      var r2 = range.cloneRange();
      r2.setStartAfter(lastNode);
      r2.collapse(true);
      sel.removeAllRanges();
      sel.addRange(r2);
    }
  }

  function insertList(type) {
    var editor = getEditor();
    if (!editor) return;
    editor.focus();
    document.execCommand(type === 'ol' ? 'insertOrderedList' : 'insertUnorderedList', false, null);
  }

  function insertInlineCode() {
    var editor = getEditor();
    if (!editor) return;
    editor.focus();
    var sel = window.getSelection();
    var text = sel.toString();
    if (!text) {
      text = 'code';
    }
    var escapedText = text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
    var html = '<code class="dc-inline-code" style="background:#f0faf5;border-radius:4px;padding:1px 5px;font-family:monospace;font-size:12px;color:#1a5c38;">' + escapedText + '</code>';
    document.execCommand('insertHTML', false, html);
  }

  function insertCodeBlock() {
    var lang = prompt("Enter programming language (CPP, Java, Python, PHP, or General):", "General");
    if (lang === null) return;
    
    var normalizedLang = lang.trim().toLowerCase();
    if (['cpp', 'c++', 'java', 'python', 'py', 'php'].indexOf(normalizedLang) !== -1) {
      if (normalizedLang === 'c++') normalizedLang = 'cpp';
      if (normalizedLang === 'py') normalizedLang = 'python';
    } else {
      normalizedLang = 'general';
    }
    
    var displayLang = 'General';
    if (normalizedLang === 'cpp') displayLang = 'C++';
    else if (normalizedLang === 'java') displayLang = 'Java';
    else if (normalizedLang === 'python') displayLang = 'Python';
    else if (normalizedLang === 'php') displayLang = 'PHP';
    
    var codePlaceholder = '// Your ' + displayLang + ' code here...';
    if (normalizedLang === 'python') codePlaceholder = '# Your Python code here...';
    
    var html = '<div class="dc-code-block-wrapper" contenteditable="false" style="margin:10px 0; border-radius:8px; overflow:hidden; border:1px solid #313244; background:#1e1e2e;">'
      + '<div class="dc-code-block-header" style="background:#11111b; color:#a6adc8; padding:6px 14px; font-size:11px; font-family:sans-serif; text-transform:uppercase; font-weight:bold; display:flex; justify-content:between; align-items:center; user-select:none;">'
      + '<span>' + displayLang + '</span>'
      + '</div>'
      + '<div class="dc-code-block" contenteditable="true" spellcheck="false" data-language="' + normalizedLang + '" style="background:#1e1e2e; color:#cdd6f4; border-radius:0 0 8px 8px; padding:12px 16px; margin:0; font-family:monospace; font-size:13px; outline:none; min-height:50px; white-space:pre; overflow-x:auto;">'
      + codePlaceholder
      + '</div>'
      + '</div><p><br></p>';
      
    insertAtCursor(html);
  }

  function insertSpoiler() {
    insertAtCursor('<div class="dc-spoiler"><div class="dc-spoiler-label">⚠ Spoiler — click to reveal</div><div class="dc-spoiler-content" contenteditable="true">Hidden content here...</div></div><p><br></p>');
  }

  function insertTable() {
    var html = '<table class="dc-table-preview"><thead><tr>'
      + '<th contenteditable="true">Header 1</th>'
      + '<th contenteditable="true">Header 2</th>'
      + '<th contenteditable="true">Header 3</th>'
      + '</tr></thead><tbody><tr>'
      + '<td contenteditable="true">Cell</td><td contenteditable="true">Cell</td><td contenteditable="true">Cell</td>'
      + '</tr><tr>'
      + '<td contenteditable="true">Cell</td><td contenteditable="true">Cell</td><td contenteditable="true">Cell</td>'
      + '</tr></tbody></table><p><br></p>';
    insertAtCursor(html);
  }

  /* ── Poll builder (create-post only) ── */

  var pollCount = 0;

  function insertPollBuilder() {
    pollCount++;
    var id = 'poll-' + pollCount;
    var html = '<div class="dc-poll-builder" id="' + id + '">'
      + '<div class="dc-poll-builder-title">'
      + '<span>📊 Poll Options</span>'
      + '<button onclick="document.getElementById(\'' + id + '\').remove()" style="background:none;border:none;color:#a1a5b7;cursor:pointer;font-size:13px;">Remove</button>'
      + '</div>'
      + '<div class="dc-poll-opts">'
      + '<div class="dc-poll-opt-row"><span style="color:#b5b5c3;cursor:grab;">⠿</span><input type="text" placeholder="Option 1"><button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button></div>'
      + '<div class="dc-poll-opt-row"><span style="color:#b5b5c3;cursor:grab;">⠿</span><input type="text" placeholder="Option 2"><button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button></div>'
      + '</div>'
      + '<button class="dc-poll-add" onclick="dcAddPollOpt(\'' + id + '\')">+ Add option</button>'
      + '</div><p><br></p>';
    insertAtCursor(html);
  }

  function dcAddPollOpt(id) {
    var wrap = document.querySelector('#' + id + ' .dc-poll-opts');
    if (!wrap) return;
    var n = wrap.querySelectorAll('.dc-poll-opt-row').length + 1;
    var row = document.createElement('div');
    row.className = 'dc-poll-opt-row';
    row.innerHTML = '<span style="color:#b5b5c3;cursor:grab;">⠿</span>'
      + '<input type="text" placeholder="Option ' + n + '">'
      + '<button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button>';
    wrap.appendChild(row);
  }

  /* ── Markdown toggle ── */

  var mdMode = false;

  function htmlToMarkdown(html) {
    var temp = document.createElement('div');
    temp.innerHTML = html;
    
    function parseNode(node) {
      if (node.nodeType === Node.TEXT_NODE) {
        return node.nodeValue;
      }
      if (node.nodeType !== Node.ELEMENT_NODE) {
        return '';
      }
      
      var tagName = node.tagName.toLowerCase();
      var children = '';
      for (var i = 0; i < node.childNodes.length; i++) {
        children += parseNode(node.childNodes[i]);
      }
      
      if (node.classList.contains('dc-code-block-wrapper')) {
        var codeBlock = node.querySelector('.dc-code-block');
        var lang = codeBlock ? (codeBlock.getAttribute('data-language') || 'general') : 'general';
        var code = codeBlock ? codeBlock.innerText : '';
        return '\n```' + lang + '\n' + code.replace(/\r\n/g, '\n').trim() + '\n```\n';
      }
      if (node.classList.contains('dc-code-block') && !node.closest('.dc-code-block-wrapper')) {
        var lang = node.getAttribute('data-language') || 'general';
        var code = node.innerText;
        return '\n```' + lang + '\n' + code.replace(/\r\n/g, '\n').trim() + '\n```\n';
      }
      
      if (node.classList.contains('dc-spoiler')) {
        var contentNode = node.querySelector('.dc-spoiler-content');
        var content = contentNode ? parseNode(contentNode) : children;
        return '\n>! ' + content.trim() + '\n';
      }
      
      if (node.classList.contains('dc-poll-builder')) {
        return '\n' + node.outerHTML + '\n';
      }
      
      if (tagName === 'table') {
        var mdTable = '\n';
        var rows = node.querySelectorAll('tr');
        rows.forEach(function(row, rIdx) {
          var cells = row.querySelectorAll('th, td');
          var mdRow = '| ';
          var mdSep = '| ';
          cells.forEach(function(cell) {
            mdRow += cell.innerText.trim() + ' | ';
            mdSep += '--- | ';
          });
          mdTable += mdRow + '\n';
          if (rIdx === 0 && row.querySelector('th')) {
            mdTable += mdSep + '\n';
          }
        });
        return mdTable + '\n';
      }
      
      if (tagName === 'code') {
        return '`' + node.innerText + '`';
      }
      
      if (tagName === 'ul') {
        var items = '';
        for (var i = 0; i < node.childNodes.length; i++) {
          var child = node.childNodes[i];
          if (child.nodeName.toLowerCase() === 'li') {
            items += '* ' + parseNode(child).trim() + '\n';
          }
        }
        return '\n' + items + '\n';
      }
      if (tagName === 'ol') {
        var items = '';
        var idx = 1;
        for (var i = 0; i < node.childNodes.length; i++) {
          var child = node.childNodes[i];
          if (child.nodeName.toLowerCase() === 'li') {
            items += idx + '. ' + parseNode(child).trim() + '\n';
            idx++;
          }
        }
        return '\n' + items + '\n';
      }
      if (tagName === 'li') {
        return children;
      }
      
      if (tagName === 'b' || tagName === 'strong') {
        return '**' + children + '**';
      }
      if (tagName === 'i' || tagName === 'em') {
        return '_' + children + '_';
      }
      if (tagName === 's' || tagName === 'strike') {
        return '~~' + children + '~~';
      }
      if (tagName === 'sup') {
        return '^' + children + '^';
      }
      
      if (tagName === 'h1') return '\n# ' + children + '\n';
      if (tagName === 'h2') return '\n## ' + children + '\n';
      if (tagName === 'h3') return '\n### ' + children + '\n';
      if (tagName === 'h4') return '\n#### ' + children + '\n';
      
      if (tagName === 'p') {
        return '\n' + children + '\n';
      }
      if (tagName === 'br') {
        return '\n';
      }
      if (tagName === 'div') {
        return '\n' + children + '\n';
      }
      
      if (tagName === 'a') {
        var href = node.getAttribute('href') || '';
        return '[' + children + '](' + href + ')';
      }
      
      if (tagName === 'img') {
        var src = node.getAttribute('src') || '';
        var alt = node.getAttribute('alt') || '';
        return '![' + alt + '](' + src + ')';
      }
      
      if (tagName === 'iframe') {
        var src = node.getAttribute('src') || '';
        return '[video](' + src + ')';
      }

      return children;
    }
    
    var markdown = parseNode(temp);
    markdown = markdown.replace(/\n{3,}/g, '\n\n').trim();
    return markdown;
  }

  function markdownToHtml(md) {
    var lines = md.split('\n');
    var html = '';
    var inCodeBlock = false;
    var codeBlockLang = '';
    var codeBlockContent = [];
    var inTable = false;
    var tableRows = [];
    var listType = null;
    var listItems = [];
    
    function flushList() {
      if (!listType) return '';
      var res = '<' + listType + '>';
      listItems.forEach(function(item) {
        res += '<li>' + parseInline(item) + '</li>';
      });
      res += '</' + listType + '>';
      listType = null;
      listItems = [];
      return res;
    }
    
    function flushTable() {
      if (!inTable || tableRows.length === 0) {
        inTable = false;
        tableRows = [];
        return '';
      }
      var res = '<table class="dc-table-preview">';
      var hasHeader = false;
      if (tableRows.length > 1) {
        var secondRow = tableRows[1].trim();
        if (/^\|?\s*:?-+:?\s*(\|?\s*:?-+:?\s*)*\|?$/.test(secondRow)) {
          hasHeader = true;
        }
      }
      tableRows.forEach(function(rowText, idx) {
        if (hasHeader && idx === 1) return;
        var cleanRow = rowText.trim();
        if (cleanRow.startsWith('|')) cleanRow = cleanRow.slice(1);
        if (cleanRow.endsWith('|')) cleanRow = cleanRow.slice(0, -1);
        var cells = cleanRow.split('|');
        var isHeaderRow = (hasHeader && idx === 0);
        var cellTag = isHeaderRow ? 'th' : 'td';
        if (idx === 0) {
          res += isHeaderRow ? '<thead><tr>' : '<tbody><tr>';
        } else if (idx === 1 && hasHeader) {
          res += '<tbody><tr>';
        } else {
          res += '<tr>';
        }
        cells.forEach(function(cell) {
          res += '<' + cellTag + ' contenteditable="true">' + parseInline(cell.trim()) + '</' + cellTag + '>';
        });
        res += '</tr>';
        if (isHeaderRow) {
          res += '</thead>';
        }
      });
      if (tableRows.length > (hasHeader ? 2 : 0)) {
        res += '</tbody>';
      }
      res += '</table>';
      inTable = false;
      tableRows = [];
      return res;
    }

    function parseInline(text) {
      var escaped = text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
      var codes = [];
      escaped = escaped.replace(/`([^`]+)`/g, function(match, codeText) {
        codes.push(codeText);
        return '___INLINE_CODE_PLACEHOLDER_' + (codes.length - 1) + '___';
      });
      escaped = escaped.replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" class="dc-img-inserted">');
      escaped = escaped.replace(/\[(.*?)\]\((.*?)\)/g, function(match, txt, url) {
        if (url.indexOf('youtube.com/embed') !== -1 || url.indexOf('youtube.com') !== -1 || url.indexOf('youtu.be') !== -1) {
          var ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([A-Za-z0-9_-]{11})/);
          if (ytMatch) {
            var embedUrl = 'https://www.youtube.com/embed/' + ytMatch[1];
            return '<iframe class="dc-video-embed" src="' + embedUrl + '" allowfullscreen></iframe>';
          }
          return '<iframe class="dc-video-embed" src="' + url + '" allowfullscreen></iframe>';
        }
        return '<a href="' + url + '" target="_blank" style="color:#3a5c45;font-weight:600;">' + txt + '</a>';
      });
      escaped = escaped.replace(/\*\*([^*]+)\*\*/g, '<b>$1</b>');
      escaped = escaped.replace(/\*([^*]+)\*/g, '<i>$1</i>');
      escaped = escaped.replace(/_([^_]+)_/g, '<i>$1</i>');
      escaped = escaped.replace(/~~([^~]+)~~/g, '<s>$1</s>');
      escaped = escaped.replace(/\^([^^]+)\^/g, '<sup>$1</sup>');
      escaped = escaped.replace(/___INLINE_CODE_PLACEHOLDER_(\d+)___/g, function(match, idx) {
        return '<code class="dc-inline-code" style="background:#f0faf5;border-radius:4px;padding:1px 5px;font-family:monospace;font-size:12px;color:#1a5c38;">' + codes[idx] + '</code>';
      });
      escaped = escaped.replace(/&lt;div class=&quot;dc-poll-builder&quot;([\s\S]*?)&lt;\/div&gt;/g, function(match) {
        var d = document.createElement('div');
        d.innerHTML = match.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"').replace(/&amp;/g, '&');
        return d.innerText || d.innerHTML;
      });
      return escaped;
    }

    for (var i = 0; i < lines.length; i++) {
      var line = lines[i];
      var trimmed = line.trim();
      
      if (inCodeBlock) {
        if (trimmed.startsWith('```')) {
          var lang = codeBlockLang || 'general';
          var displayLang = 'General';
          if (lang === 'cpp') displayLang = 'C++';
          else if (lang === 'java') displayLang = 'Java';
          else if (lang === 'python') displayLang = 'Python';
          else if (lang === 'php') displayLang = 'PHP';
          
          var codeContent = codeBlockContent.join('\n');
          if (!codeContent.trim()) {
            codeContent = '// Your ' + displayLang + ' code here...';
            if (lang === 'python') codeContent = '# Your Python code here...';
          }
          var escapedCode = codeContent
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
            
          html += '<div class="dc-code-block-wrapper" contenteditable="false" style="margin:10px 0; border-radius:8px; overflow:hidden; border:1px solid #313244; background:#1e1e2e;">'
            + '<div class="dc-code-block-header" style="background:#11111b; color:#a6adc8; padding:6px 14px; font-size:11px; font-family:sans-serif; text-transform:uppercase; font-weight:bold; display:flex; justify-content:space-between; align-items:center; user-select:none;">'
            + '<span>' + displayLang + '</span>'
            + '</div>'
            + '<div class="dc-code-block" contenteditable="true" spellcheck="false" data-language="' + lang + '" style="background:#1e1e2e; color:#cdd6f4; border-radius:0 0 8px 8px; padding:12px 16px; margin:0; font-family:monospace; font-size:13px; outline:none; min-height:50px; white-space:pre; overflow-x:auto;">'
            + escapedCode
            + '</div>'
            + '</div><p><br></p>';
          inCodeBlock = false;
          codeBlockContent = [];
        } else {
          codeBlockContent.push(line);
        }
        continue;
      }
      
      if (trimmed.startsWith('```')) {
        html += flushList();
        html += flushTable();
        inCodeBlock = true;
        codeBlockLang = trimmed.slice(3).trim().toLowerCase();
        continue;
      }
      
      if (trimmed.startsWith('|')) {
        html += flushList();
        inTable = true;
        tableRows.push(line);
        continue;
      } else if (inTable) {
        html += flushTable();
      }
      
      if (trimmed.startsWith('>!')) {
        html += flushList();
        var spoilerText = trimmed.slice(2).trim();
        html += '<div class="dc-spoiler">'
          + '<div class="dc-spoiler-label">⚠ Spoiler — click to reveal</div>'
          + '<div class="dc-spoiler-content" contenteditable="true">' + parseInline(spoilerText) + '</div>'
          + '</div><p><br></p>';
        continue;
      }
      
      if (trimmed.startsWith('#')) {
        html += flushList();
        var depth = 0;
        while (depth < trimmed.length && trimmed[depth] === '#') {
          depth++;
        }
        var headerText = trimmed.slice(depth).trim();
        if (depth >= 1 && depth <= 4) {
          html += '<h' + depth + '>' + parseInline(headerText) + '</h' + depth + '>';
        } else {
          html += '<p>' + parseInline(trimmed) + '</p>';
        }
        continue;
      }
      
      var ulMatch = line.match(/^(\s*)[*+-]\s+(.*)$/);
      if (ulMatch) {
        if (listType !== 'ul') {
          html += flushList();
          listType = 'ul';
        }
        listItems.push(ulMatch[2]);
        continue;
      }
      
      var olMatch = line.match(/^(\s*)\d+\.\s+(.*)$/);
      if (olMatch) {
        if (listType !== 'ol') {
          html += flushList();
          listType = 'ol';
        }
        listItems.push(olMatch[2]);
        continue;
      }
      
      html += flushList();
      if (trimmed === '') {
        html += '<p><br></p>';
      } else {
        if (trimmed.startsWith('<div class="dc-poll-builder"') || trimmed.startsWith('<iframe class="dc-video-embed"')) {
          html += line;
        } else {
          html += '<p>' + parseInline(line) + '</p>';
        }
      }
    }
    
    html += flushList();
    html += flushTable();
    return html;
  }

  function getEditorHtml() {
    var editor = getEditor();
    if (!editor) return '';
    var taId = (window.DC_EDITOR_ID || 'dc') + '-md-textarea';
    var ta = document.getElementById(taId);
    if (mdMode && ta) {
      return markdownToHtml(ta.value);
    }
    return editor.innerHTML;
  }

  function toggleMarkdown(e) {
    e.preventDefault();
    var editor = getEditor();
    if (!editor) return;
    var taId = (window.DC_EDITOR_ID || 'dc') + '-md-textarea';
    mdMode = !mdMode;
    if (mdMode) {
      var md = htmlToMarkdown(editor.innerHTML);
      editor.contentEditable = 'false';
      editor.style.display = 'none';
      var ta = document.getElementById(taId);
      if (!ta) {
        ta = document.createElement('textarea');
        ta.id = taId;
        ta.className = 'dc-editor-area';
        ta.style.borderTop = '1.5px solid #e4e6ef';
        ta.style.borderRadius = '0 0 8px 8px';
        editor.parentNode.insertBefore(ta, editor.nextSibling);
      }
      ta.value = md;
      ta.style.display = 'block';
      e.target.textContent = 'Switch to Visual';
    } else {
      var ta2 = document.getElementById(taId);
      if (ta2) {
        editor.innerHTML = markdownToHtml(ta2.value);
        ta2.style.display = 'none';
      }
      editor.contentEditable = 'true';
      editor.style.display = 'block';
      e.target.textContent = 'Switch to Markdown';
    }
  }

  /* ── Modal helpers (Bootstrap 5) ── */

  function openModal(id) {
    new bootstrap.Modal(document.getElementById(id)).show();
  }

  function closeModal(id) {
    var inst = bootstrap.Modal.getInstance(document.getElementById(id));
    if (inst) inst.hide();
  }

  function insertLink() {
    var txt = document.getElementById('link-text').value || document.getElementById('link-url').value;
    var url = document.getElementById('link-url').value;
    if (!url) return;
    insertAtCursor('<a href="' + url + '" target="_blank" style="color:#3a5c45;font-weight:600;">' + txt + '</a>');
    closeModal('modal-link');
    document.getElementById('link-text').value = '';
    document.getElementById('link-url').value = '';
  }

  function insertImage() {
    var file = document.getElementById('img-file') && document.getElementById('img-file').files[0];
    var url = document.getElementById('img-url') && document.getElementById('img-url').value;
    var alt = (document.getElementById('img-alt') && document.getElementById('img-alt').value) || 'Image';
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        insertAtCursor('<img src="' + e.target.result + '" alt="' + alt + '" class="dc-img-inserted">');
      };
      reader.readAsDataURL(file);
    } else if (url) {
      insertAtCursor('<img src="' + url + '" alt="' + alt + '" class="dc-img-inserted">');
    }
    closeModal('modal-image');
    if (document.getElementById('img-url')) document.getElementById('img-url').value = '';
    if (document.getElementById('img-alt')) document.getElementById('img-alt').value = '';
    if (document.getElementById('img-file')) document.getElementById('img-file').value = '';
  }

  function insertVideo() {
    var url = document.getElementById('video-url').value.trim();
    if (!url) return;
    var ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/);
    if (ytMatch) url = 'https://www.youtube.com/embed/' + ytMatch[1];
    insertAtCursor('<iframe class="dc-video-embed" src="' + url + '" allowfullscreen></iframe><p><br></p>');
    closeModal('modal-video');
    document.getElementById('video-url').value = '';
  }

  /* ── Image replace/remove (edit-post & edit-poll) ── */

  function removeImage() {
    var wrapper = document.getElementById('imageWrapper');
    var placeholder = document.getElementById('noImagePlaceholder');
    if (wrapper) wrapper.style.display = 'none';
    if (placeholder) placeholder.style.display = 'block';
  }

  function replaceImage(event) {
    var file = event.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      var img = document.getElementById('attachedImage');
      if (img) img.src = e.target.result;
      var wrapper = document.getElementById('imageWrapper');
      var placeholder = document.getElementById('noImagePlaceholder');
      if (wrapper) wrapper.style.display = 'block';
      if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
    event.target.value = '';
  }

  function pollRemoveImage() {
    var wrapper = document.getElementById('pollImageWrapper');
    var placeholder = document.getElementById('pollNoImagePlaceholder');
    if (wrapper) wrapper.style.display = 'none';
    if (placeholder) placeholder.style.display = 'block';
  }

  function pollReplaceImage(event) {
    var file = event.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      var img = document.getElementById('pollAttachedImage');
      if (!img) {
        img = document.createElement('img');
        img.id = 'pollAttachedImage';
        img.className = 'dc-img-inserted';
        img.style.cssText = 'max-height:220px;width:100%;object-fit:cover;margin:0;';
        var wrapper = document.getElementById('pollImageWrapper');
        if (wrapper) wrapper.prepend(img);
      }
      img.src = e.target.result;
      var wrapper = document.getElementById('pollImageWrapper');
      var placeholder = document.getElementById('pollNoImagePlaceholder');
      if (wrapper) wrapper.style.display = 'block';
      if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
    event.target.value = '';
  }

  /* ── Tag input (create-post only) ── */

  function dcInitTagInput() {
    var tagInput = document.getElementById('tag-input');
    var tagWrap = document.getElementById('tag-wrap');
    if (!tagInput || !tagWrap) return;
    var tags = [];

    tagInput.addEventListener('keydown', function (e) {
      if ((e.key === 'Enter' || e.key === ',') && tagInput.value.trim()) {
        e.preventDefault();
        var v = tagInput.value.trim().replace(/,/g, '');
        if (v && !tags.includes(v)) {
          tags.push(v);
          renderTags();
        }
        tagInput.value = '';
      }
      if (e.key === 'Backspace' && !tagInput.value && tags.length) {
        tags.pop();
        renderTags();
      }
    });

    function renderTags() {
      tagWrap.querySelectorAll('.badge').forEach(function (t) { t.remove(); });
      tags.forEach(function (tag, i) {
        var t = document.createElement('span');
        t.className = 'badge rounded-pill px-3 py-2 fs-8 d-inline-flex align-items-center gap-1';
        t.style.cssText = 'background-color:#dce8df;color:#3a5c45;';
        t.innerHTML = tag + '<button type="button" class="btn-close btn-close-sm ms-1" style="font-size:9px;"></button>';
        t.querySelector('.btn-close').onclick = function () {
          tags.splice(i, 1);
          renderTags();
        };
        tagWrap.insertBefore(t, tagInput);
      });
    }
  }

  /* ── Submit helpers ── */

  function submitPost() {
    var title = document.getElementById('post_title');
    if (title && !title.value.trim()) { title.focus(); return; }
    if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
  }

  function discardPost() {
    if (confirm('Discard this post? Your changes will be lost.')) window.history.back();
  }

  function savePost() {
    var title = document.getElementById('edit_title');
    if (title && !title.value.trim()) { title.focus(); return; }
    if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
  }

  function confirmDelete() {
    var urlParams = new URLSearchParams(window.location.search);
    var postId = urlParams.get('id');
    if (!postId) {
      alert('Cannot delete this post (invalid ID).');
      return;
    }
    if (confirm('Are you sure you want to permanently delete this post? This cannot be undone.')) {
      if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
      $.ajax({
        url: '/Discourse/posts/index-ajax-delete-post.php',
        method: 'POST',
        data: { id: postId },
        dataType: 'json',
        success: function(res) {
          if (res.status === 'success') {
            alert(res.message);
            window.location.href = '/Discourse/index.php';
          } else {
            if (typeof KTApp !== 'undefined') KTApp.hidePageLoading();
            alert(res.message || 'Failed to delete post.');
          }
        },
        error: function() {
          if (typeof KTApp !== 'undefined') KTApp.hidePageLoading();
          alert('Error communicating with database.');
        }
      });
    }
  }

  function savePoll() {
    var title = document.getElementById('poll_title');
    if (title && !title.value.trim()) { title.focus(); return; }
    if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
  }

  function changeIdentity(event, text, avatarUrl) {
    event.preventDefault();
    document.getElementById('display_identity_text').innerText = text;
    document.getElementById('display_identity_avatar').src = avatarUrl;
    document.querySelectorAll('#identityDropdown + .dropdown-menu .dropdown-item').forEach(function (link) {
      link.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
  }

  /* ── Poll option management (edit-poll only) ── */

  var newOptionCount = 0;

  function addPollOption() {
    newOptionCount++;
    var wrap = document.getElementById('new-options-wrap');
    if (!wrap) return;
    var row = document.createElement('div');
    row.className = 'd-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2';
    row.id = 'new-opt-' + newOptionCount;
    row.innerHTML = '<span class="text-muted fs-6" style="cursor:grab;">⠿</span>'
      + '<input type="text" class="form-control form-control-solid flex-grow-1" placeholder="New option ' + newOptionCount + '...">'
      + '<span class="text-muted fs-8 fw-semibold text-nowrap">0 votes</span>'
      + '<button class="btn btn-sm btn-icon btn-light-danger" title="Remove option" onclick="dcRemoveOption(\'new-opt-' + newOptionCount + '\')" type="button">'
      + '<i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>'
      + '</button>';
    wrap.appendChild(row);
    row.querySelector('input').focus();
  }

  function dcRemoveOption(id) {
    var el = document.getElementById(id);
    if (el) el.remove();
  }

  /* ── Expose to global scope ── */
  window.fmt               = fmt;
  window.insertAtCursor    = insertAtCursor;
  window.insertList        = insertList;
  window.insertInlineCode  = insertInlineCode;
  window.insertCodeBlock   = insertCodeBlock;
  window.insertSpoiler     = insertSpoiler;
  window.insertTable       = insertTable;
  window.insertPollBuilder = insertPollBuilder;
  window.dcAddPollOpt      = dcAddPollOpt;
  window.toggleMarkdown    = toggleMarkdown;
  window.getEditorHtml     = getEditorHtml;
  window.openModal         = openModal;
  window.closeModal        = closeModal;
  window.insertLink        = insertLink;
  window.insertImage       = insertImage;
  window.insertVideo       = insertVideo;
  window.removeImage       = removeImage;
  window.replaceImage      = replaceImage;
  window.pollRemoveImage   = pollRemoveImage;
  window.pollReplaceImage  = pollReplaceImage;
  window.submitPost        = submitPost;
  window.discardPost       = discardPost;
  window.savePost          = savePost;
  window.confirmDelete     = confirmDelete;
  window.savePoll          = savePoll;
  window.changeIdentity    = changeIdentity;
  window.addPollOption     = addPollOption;
  window.dcRemoveOption    = dcRemoveOption;

  document.addEventListener('DOMContentLoaded', function () {
    dcInitTagInput();
  });

})();
