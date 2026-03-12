<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Modern Base Styles */
        body {
            background-color: #0f172a; /* Slate 900 */
            color: #f8fafc; /* Slate 50 */
        }
        .main {
            min-height: calc(100vh - 120px);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="bg-slate-900 text-slate-50 font-sans antialiased">
    <nav class="bg-slate-800/50 backdrop-blur-md border-b border-slate-700/50 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-2 group">
                    <i data-lucide="shield" class="w-8 h-8 text-blue-500 group-hover:text-blue-400 transition-colors"></i>
                    <span class="font-bold text-xl tracking-tight text-white uppercase">Surveillance<span class="text-blue-500">Hub</span></span>
                </a>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Dashboard</a>
                <a href="<?= $this->Url->build(['controller' => 'Stores', 'action' => 'index']) ?>" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Shops</a>
                <a href="<?= $this->Url->build(['controller' => 'Cameras', 'action' => 'index']) ?>" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Cameras</a>
                <a href="<?= $this->Url->build(['controller' => 'Categories', 'action' => 'index']) ?>" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Categories</a>
                <a href="<?= $this->Url->build(['controller' => 'Accessories', 'action' => 'index']) ?>" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Accessories</a>
                <a target="_blank" rel="noopener" href="https://book.cakephp.org/5/" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Documentation</a>
            </div>
            <div class="flex md:hidden">
                 <i data-lucide="menu" class="w-6 h-6 text-slate-400"></i>
            </div>
        </div>
    </nav>
    <main class="main py-8">
        <div class="container mx-auto px-6">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer class="bg-slate-900 border-t border-slate-800 py-10 mt-12">
        <div class="container mx-auto px-6 text-center">
            <div class="flex justify-center items-center gap-2 mb-4 opacity-50">
                <i data-lucide="shield" class="w-5 h-5 text-blue-500"></i>
                <span class="font-bold text-lg tracking-tight text-white uppercase">Surveillance<span class="text-blue-500">Hub</span></span>
            </div>
            <p class="text-slate-500 text-sm">
                &copy; <?= date('Y') ?> SurveillanceHub. Powered by CakePHP 5 & Tailwind CSS.
            </p>
        </div>
    </footer>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
