<template>
  <nav class="flex items-center justify-between px-6 py-4 mb-10">
    <img class="w-10 shadow-lg" src="../images/logo.png" alt="logo" />
  </nav>
  <div class="px-4">
    <Vueform>
      <template #empty>
        <FormSteps>
          <FormStep
            name="first"
            label="နံပါတ်ရွေးပါ"
            :elements="['first_input']"
          />
          <FormStep
            name="second"
            label="အချက်လက်များဖြည့်ပါ"
            :elements="['second_input']"
          />
          <FormStep
            name="third"
            label="ငွေပေးချေပါ"
            :elements="['third_input']"
          />
        </FormSteps>

        <FormElements>
          <TextElement size="lg" name="first_input" placeholder="First input" />
          <TextElement size="lg" name="first_input" placeholder="First input" />
          <TextElement size="lg" name="first_input" placeholder="First input" />
          <TextElement
            size="lg"
            name="second_input"
            placeholder="Second input"
          />
          <TextElement size="lg" name="third_input" placeholder="Third input" />
        </FormElements>

        <FormStepsControls />
      </template>
    </Vueform>
  </div>
</template>