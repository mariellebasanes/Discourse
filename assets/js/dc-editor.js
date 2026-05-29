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

  function insertCodeBlock() {
    insertAtCursor('<div class="dc-code-block" contenteditable="true" spellcheck="false">// Your code here...</div><p><br></p>');
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

  function toggleMarkdown(e) {
    e.preventDefault();
    var editor = getEditor();
    if (!editor) return;
    var taId = (window.DC_EDITOR_ID || 'dc') + '-md-textarea';
    mdMode = !mdMode;
    if (mdMode) {
      var md = editor.innerHTML
        .replace(/<b>(.*?)<\/b>/gi, '**$1**')
        .replace(/<i>(.*?)<\/i>/gi, '_$1_')
        .replace(/<br\s*\/?>/gi, '\n')
        .replace(/<[^>]+>/g, '')
        .replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
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
        editor.innerHTML = ta2.value.replace(/\n/g, '<br>');
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
    if (confirm('Are you sure you want to permanently delete this post? This cannot be undone.')) {
      if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
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
  window.insertCodeBlock   = insertCodeBlock;
  window.insertSpoiler     = insertSpoiler;
  window.insertTable       = insertTable;
  window.insertPollBuilder = insertPollBuilder;
  window.dcAddPollOpt      = dcAddPollOpt;
  window.toggleMarkdown    = toggleMarkdown;
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
