<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<p>Hi <?php echo e($user['name']); ?>,</p>
<p style="text-align: left;padding-top: 20px">
    <?php echo e($message); ?>

</p>
<p style="text-align: left;padding-top: 20px; font-size: 10px; color:red; font-style: italic;">
    This is an automated message from the system to inform you about the latest update on
    the water level status of the designated river in Villa Celestial. We aim to keep you
    informed and ensure your safety. Please stay tuned for further updates.
</p>
<div style="padding-top: 40px">
<span >Be Safe and GodBless!,</span><br/>
<span><?php echo e(config('app.name')); ?></span>

</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ROGER\Downloads\e-Rescue-dev-roger\resources\views/mail/notifications/status-notif-mail.blade.php ENDPATH**/ ?>