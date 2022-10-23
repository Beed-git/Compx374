package com.google.ar.core.examples.java.webapi.models;

public class Artist {
    public int id;
    public String email;
    public String username;
    public String password;
    public String story;

    @Override
    public String toString() {
        return String.format("%d\n%s\n%s\n%s\n%s", id, email, username, password, story);
    }
}
