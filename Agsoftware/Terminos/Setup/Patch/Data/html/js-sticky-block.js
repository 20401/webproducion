<script>
  (function() {
    // INITIALIZATION OF STICKY BLOCKS
    // =======================================================
    new HSStickyBlock('.js-sticky-block', {
      targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
    })
  });
</script>