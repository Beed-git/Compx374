package com.google.ar.core.examples.java.helloar;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import org.mindrot.jbcrypt.BCrypt;

import com.google.ar.core.examples.java.webapi.WebApiThread;
import com.google.ar.core.examples.java.webapi.models.Artist;
import com.google.ar.core.examples.java.webapi.models.ArtistRoot;

public class RegisterActivity extends AppCompatActivity {
    EditText firstName, lastName, email, password, passwordConfirm;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        firstName               = findViewById(R.id.editTextTextFirstName);
        lastName               = findViewById(R.id.editTextTextLastName);
        email                   = findViewById(R.id.editTextTextEmailAddressRegister);
        password                = findViewById(R.id.editTextTextPasswordRegister1);
        passwordConfirm         = findViewById(R.id.editTextTextPasswordRegister2);

        final Button buttonRegister = findViewById(R.id.buttonConfirmRegister);
        buttonRegister.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                // Check requirements for names
                String regexPattern = "^[A-Za-z][A-Za-z0-9_]{1,29}$";
                if (!firstName.getText().toString().matches(regexPattern))
                {
                    Toast toast = Toast.makeText(RegisterActivity.this,
                            "Incorrect first name format",
                            Toast.LENGTH_SHORT);
                    toast.show();
                    return;
                }
                if (!lastName.getText().toString().matches(regexPattern))
                {
                    Toast toast = Toast.makeText(RegisterActivity.this,
                            "Incorrect last name format",
                            Toast.LENGTH_SHORT);
                    toast.show();
                    return;
                }
                // Check valid email address
                regexPattern = "^(.+)@(\\S+)$";
                if (!email.getText().toString().matches(regexPattern))
                {
                    Toast toast = Toast.makeText(RegisterActivity.this,
                            "Incorrect email format",
                            Toast.LENGTH_SHORT);
                    toast.show();
                    return;
                }
                // If email exists, display message saying account already exists with this email
                try {
                    Artist artist = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/artists/?email=" + email.getText().toString(), ArtistRoot.class).get().artist;
                    if (artist != null){
                        Toast toast = Toast.makeText(RegisterActivity.this,
                                "Account already exists with this email",
                                Toast.LENGTH_SHORT);
                        toast.show();
                        password.setText("");
                    }
                    return;
                }
                catch (Exception ex){
                    ex.printStackTrace();
                }
                // Check password meets requirement
                regexPattern = "^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}$";
                if (!password.getText().toString().matches(regexPattern))
                {
                    Toast toast = Toast.makeText(RegisterActivity.this,
                            "Incorrect password format",
                            Toast.LENGTH_SHORT);
                    toast.show();
                    return;
                }
                // Check password matches passwordConfirm
                if (!password.getText().toString().equals(passwordConfirm.getText().toString())){
                    Toast toast = Toast.makeText(RegisterActivity.this,
                            "Passwords do not match",
                            Toast.LENGTH_SHORT);
                    toast.show();
                    return;
                }
                // Create new artist in the database
                String username = firstName.getText().toString() + " " + lastName.getText().toString();
                String hashedPW = BCrypt.hashpw(password.getText().toString(), BCrypt.gensalt());
                System.out.println(BCrypt.checkpw(password.getText().toString(), hashedPW));
                String query = "insert into Artist(email,username,password) values('" + email.getText().toString() + "','" + username + "','" + hashedPW + "')";

                // Enter app with newly registered account
                // TODO pass id when entering app
                registerFinish(findViewById(R.id.buttonConfirmRegister));
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

    public void registerFinish(View v) {
        Intent intent = new Intent(this, HomeActivity.class);
        startActivity(intent);
    }
}