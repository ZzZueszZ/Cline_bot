<?php
/**
 * @var \App\View\AppView $this
 * @var string $username
 * @var string $greeting
 */
$this->assign('title', 'Chat');
?>

<div class="max-w-3xl mx-auto">
    <div class="bg-slate-800/50 backdrop-blur-md border border-slate-700/50 rounded-2xl p-8 shadow-xl">
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="message-circle" class="w-8 h-8 text-blue-500"></i>
            <h1 class="text-2xl font-bold text-white">Chat</h1>
        </div>

        <div class="bg-slate-900/50 rounded-xl p-6 mb-6 border border-slate-700/30">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="bot" class="w-5 h-5 text-blue-400"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-400 mb-1">SurveillanceHub Bot</p>
                    <p class="text-white text-lg" id="greeting-message"><?= h($greeting) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
