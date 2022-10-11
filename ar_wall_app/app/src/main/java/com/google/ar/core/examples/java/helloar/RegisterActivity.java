package com.google.ar.core.examples.java.helloar;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class RegisterActivity extends AppCompatActivity {
    EditText email, password, passwordConfirm;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        email                   = findViewById(R.id.editTextTextEmailAddressRegister);
        password                = findViewById(R.id.editTextTextPasswordRegister1);
        passwordConfirm         = findViewById(R.id.editTextTextPasswordRegister2);

        final Button buttonRegister = findViewById(R.id.buttonConfirmRegister);
        buttonRegister.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                // Check valid email address
                // If email exists, display message saying account already exists with this email
                // Check password meets requirement
                // Check password matches passwordConfirm
                // Enter app with newly registered account
            }
        });

        final Button buttonCancel = findViewById(R.id.buttonCancelRegister);
        buttonCancel.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                // Go back to login screen
                finish();
            }
        });
    }


}