

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><?php echo e($session->subject); ?></h5>
                        <small class="text-white-50">جلسة الدعم #<?php echo e($session->id); ?></small>
                    </div>
                    <form action="<?php echo e(route('support.end', $session->id)); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من إنهاء الجلسة؟ سيتم حذف جميع الرسائل.');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-sm">إنهاء الجلسة</button>
                    </form>
                </div>

                <div class="card-body p-0">
                    <!-- منطقة الرسائل -->
                    <div id="chat-messages" class="chat-messages p-3" style="height: 400px; overflow-y: auto;">
                        <?php if($session->messages->count() > 0): ?>
                            <?php $__currentLoopData = $session->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="message <?php echo e($message->sender_id == auth()->id() ? 'user-message' : 'support-message'); ?> mb-3">
                                    <div class="card <?php echo e($message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light'); ?> shadow-sm">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong class="small">
                                                    <?php echo e($message->sender_id == auth()->id() ? 'أنت' : 'موظف الدعم'); ?>

                                                </strong>
                                                <small class="text-<?php echo e($message->sender_id == auth()->id() ? 'light' : 'muted'); ?>">
                                                    <?php echo e($message->created_at->format('H:i')); ?>

                                                </small>
                                            </div>
                                            <p class="mb-0"><?php echo e($message->message); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <p>لا توجد رسائل بعد. ابدأ المحادثة الآن!</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- نموذج إرسال الرسائل -->
                    <div class="chat-input p-3 bg-light border-top">
                        <form action="<?php echo e(route('support.send', $session->id)); ?>" method="POST" id="message-form">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input type="text" class="form-control" name="message" id="message-input" placeholder="اكتب رسالتك هنا..." required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> إرسال
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('styles'); ?>
<style>
    .chat-messages {
        background-color: #f8f9fa;
    }

    .user-message {
        margin-left: 20%;
    }

    .support-message {
        margin-right: 20%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // تخزين آخر معرف رسالة
    let lastMessageId = <?php echo e($session->messages->last()->id ?? 0); ?>;

    // تحديث الرسائل تلقائياً كل 3 ثواني
    setInterval(function() {
        fetch('<?php echo e(route('support.messages', $session->id)); ?>?last_message_id=' + lastMessageId)
            .then(response => response.json())
            .then(data => {
                if (data.messages.length > 0) {
                    data.messages.forEach(message => {
                        const messageHtml = `
                            <div class="message ${message.sender_id === <?php echo e(auth()->id()); ?> ? 'user-message' : 'support-message'} mb-3">
                                <div class="card ${message.sender_id === <?php echo e(auth()->id()); ?> ? 'bg-primary text-white' : 'bg-light'} shadow-sm">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="small">
                                                ${message.sender_id === <?php echo e(auth()->id()); ?> ? 'أنت' : 'موظف الدعم'}
                                            </strong>
                                            <small class="text-${message.sender_id === <?php echo e(auth()->id()); ?> ? 'light' : 'muted'}">
                                                ${message.created_at}
                                            </small>
                                        </div>
                                        <p class="mb-0">${message.message}</p>
                                    </div>
                                </div>
                            </div>
                        `;

                        document.getElementById('chat-messages').insertAdjacentHTML('beforeend', messageHtml);
                        lastMessageId = message.id;
                    });

                    // التمرير إلى أسفل المحادثة
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                // التحقق من حالة الجلسة
                if (!data.session_active) {
                    alert('تم إنهاء الجلسة من قبل موظف الدعم.');
                    window.location.href = '<?php echo e(route('support.index')); ?>';
                }
            });
    }, 3000);

    // إرسال الرسالة عبر AJAX
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message) {
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                } else {
                    alert(data.message || 'حدث خطأ أثناء إرسال الرسالة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إرسال الرسالة');
            });
        }
    });

    // التمرير إلى أسفل المحادثة عند تحميل الصفحة
    window.addEventListener('load', function() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/support/chat.blade.php ENDPATH**/ ?>