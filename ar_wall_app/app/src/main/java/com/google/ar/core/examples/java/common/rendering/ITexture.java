package com.google.ar.core.examples.java.common.rendering;

import java.io.Closeable;

public interface ITexture extends Closeable {
    int getTextureId();
    void bind();
}
